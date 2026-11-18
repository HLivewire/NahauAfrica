<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    private function query(Request $r)
    {
        $q = ActivityLog::query()->latest('id');
        if ($s = trim((string) $r->query('q'))) {
            $q->where(fn ($w) => $w->where('description', 'like', "%$s%")->orWhere('user_name', 'like', "%$s%")->orWhere('subject_label', 'like', "%$s%")->orWhere('ip', 'like', "%$s%"));
        }
        if ($a = $r->query('action')) {
            $q->where('action', $a);
        }
        if ($t = $r->query('type')) {
            $q->where('subject_type', $t);
        }
        if ($u = $r->query('user')) {
            $q->where('user_id', (int) $u);
        }
        if ($f = $r->query('from')) {
            $q->where('created_at', '>=', $f.' 00:00:00');
        }
        if ($to = $r->query('to')) {
            $q->where('created_at', '<=', $to.' 23:59:59');
        }

        return $q;
    }

    public function index(Request $r)
    {
        $rows = $this->query($r)->paginate(30)->withQueryString();
        $since = now()->subDay();
        $stats = [
            'today' => ActivityLog::where('created_at', '>=', now()->startOfDay())->count(),
            'logins' => ActivityLog::where('action', 'login')->where('created_at', '>=', $since)->count(),
            'failed' => ActivityLog::where('action', 'login_failed')->where('created_at', '>=', $since)->count(),
            'users' => ActivityLog::where('created_at', '>=', $since)->whereNotNull('user_id')->distinct('user_id')->count('user_id'),
        ];
        $people = ActivityLog::whereNotNull('user_id')->select('user_id', 'user_name')->groupBy('user_id', 'user_name')->orderBy('user_name')->limit(200)->get();
        $types = ActivityLog::whereNotNull('subject_type')->distinct()->orderBy('subject_type')->pluck('subject_type');

        return view('nahau-admin.audit', compact('rows', 'stats', 'people', 'types'));
    }

    public function show(Request $r, ActivityLog $log)
    {
        return $r->ajax()
            ? view('nahau-admin.audit-show', ['l' => $log])
            : view('nahau-admin.page', ['partial' => 'nahau-admin.audit-show', 'data' => ['l' => $log], 'title' => 'Audit Activity']);
    }

    public function export(Request $r)
    {
        $q = $this->query($r);

        return response()->streamDownload(function () use ($q) {
            $o = fopen('php://output', 'w');
            fwrite($o, "\xEF\xBB\xBF");
            fputcsv($o, ['Time', 'User', 'Role', 'Action', 'Type', 'Subject', 'Description', 'IP', 'URL']);
            $q->limit(20000)->cursor()->each(fn ($l) => fputcsv($o, array_map(fn ($v) => preg_match('/^[=+\-@]/', (string) $v) ? "'".$v : $v, [$l->created_at, $l->user_name, $l->user_role, $l->action, $l->subject_type, $l->subject_label, $l->description, $l->ip, $l->url])));
            fclose($o);
        }, 'audit-activity-'.now()->format('Ymd-His').'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}
