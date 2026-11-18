<?php

namespace App\Nahau;

/** Admin panel language: Kiswahili is the source text, English is applied on output (one phrase list for views, JSON and JS). */
class AdminLang
{
    public const DICT = [
        // audit activity
        'Kila kinachofanyika kwenye mfumo: nani, nini, lini, na kutoka wapi. Rekodi hizi haziwezi kubadilishwa wala kufutwa.' => 'Everything that happens in the system: who, what, when and from where. These records cannot be edited or deleted.',
        'Pakua CSV' => 'Download CSV', 'Matukio leo' => 'Events today', 'Walioingia (saa 24)' => 'Logins (24h)', 'Kuingia kulikoshindwa (saa 24)' => 'Failed logins (24h)', 'Watumiaji hai (saa 24)' => 'Active users (24h)',
        'Tafuta maelezo, mtumiaji au IP…' => 'Search description, user or IP…', 'Vitendo vyote' => 'All actions', 'Aina zote' => 'All types', 'Watumiaji wote' => 'All users', 'Futa vichujio' => 'Clear filters',
        'Hakuna matukio.' => 'No events.', 'Shughuli zitaonekana hapa kadri watumiaji wanavyotumia mfumo.' => 'Activity will appear here as people use the system.',
        'Wakati' => 'When', 'Mtumiaji' => 'User', 'Kitendo' => 'Action', 'Maelezo' => 'Details', 'Angalia' => 'View', 'Kilichoguswa' => 'Affected item', 'Ombi' => 'Request', 'Kifaa' => 'Device', 'Mabadiliko' => 'Changes', 'Sehemu' => 'Field', 'Kabla' => 'Before', 'Baada' => 'After', 'Mgeni' => 'Guest', 'Msomaji' => 'Reader',
        'Ameingia' => 'Logged in', 'Ametoka' => 'Logged out', 'Kuingia kumeshindwa' => 'Login failed', 'Ameongeza' => 'Created', 'Amebadilisha' => 'Updated', 'Amefuta' => 'Deleted', 'Amebadilisha nenosiri' => 'Changed password', 'Amebadilisha role' => 'Changed role',
        'Ameingia kwenye mfumo' => 'Logged in', 'Ametoka kwenye mfumo' => 'Logged out', 'Kuingia kumeshindwa:' => 'Login failed:', 'Role ya' => 'Role of',
        // shell
        'Fungua menyu' => 'Open menu', 'Menyu kuu' => 'Main menu', 'Punguza sidebar' => 'Collapse sidebar',
        'Tafuta ukurasa au kazi…' => 'Search a page or task…', 'Tafuta' => 'Search', 'Badilisha mwonekano (giza au mwanga)' => 'Switch light or dark mode',
        'Badilisha lugha' => 'Change language', 'Arifa' => 'Notifications', 'Hakuna arifa mpya' => 'No new notifications', 'Fungua Inbox' => 'Open Inbox',
        'Njia za mkato' => 'Shortcuts', 'Hadithi mpya' => 'New story', 'Fursa mpya' => 'New opportunity', 'Mwandishi' => 'Author',
        'Alika mtumiaji' => 'Invite user', 'Nenosiri' => 'Password', 'Tazama site' => 'View site', 'Akaunti yangu' => 'My account',
        'Wasifu wangu' => 'My profile', 'Usalama na nenosiri' => 'Security and password', 'Alika Administrator mwingine' => 'Invite another Administrator',
        'Toka' => 'Sign out', 'Tafadhali badilisha nenosiri lako la mwanzo sasa hivi.' => 'Please change your first password now.',
        'Badilisha nenosiri' => 'Change password', 'Kwa usalama, weka nenosiri jipya kabla ya kuendelea.' => 'For your safety, set a new password before continuing.',
        // nav
        'Hadithi zote' => 'All stories', 'Maelezo ya hadithi' => 'Story details', 'Ujumbe' => 'Messages', 'Maombi ya fursa' => 'Opportunity requests',
        'Submissions za hadithi' => 'Story submissions', 'Pages za sera' => 'Policy pages', 'Users na Roles' => 'Users and Roles', 'Hadithi' => 'Stories',
        // dashboard
        'Habari,' => 'Hello,', 'karibu' => 'welcome', 'Hali ya NahauAfrica leo. Namba zote ni halisi kutoka kwenye site.' => 'How NahauAfrica is doing today. All numbers are real, taken from the site.',
        'Hadithi zilizochapishwa kwa mwezi' => 'Stories published per month', 'Hadithi zilizochapishwa' => 'Published stories', 'Mpya kwenye Inbox' => 'New in Inbox',
        'Fursa zilizo wazi' => 'Open opportunities', 'Miezi 6 iliyopita (kwa tarehe ya hadithi)' => 'Last 6 months (by story date)',
        'Wasomaji (views)' => 'Readers (views)', 'Jumla ya hadithi zote' => 'Total across all stories', 'kutoka kwenye hesabu ya site' => 'from the site counter',
        'Waliothibitisha barua pepe' => 'Email confirmed', 'Waandishi waliosajiliwa' => 'Registered authors', 'Fursa zinazosubiri uhakiki' => 'Opportunities awaiting verification',
        'Hazijathibitishwa bado' => 'Not verified yet', 'zinahitaji kazi' => 'need attention', 'Lugha za hadithi' => 'Story languages', 'Kila hadithi ina lugha moja' => 'Each story has one language',
        'Kipindi' => 'Period', 'Siku 7 zilizopita' => 'Last 7 days', 'Siku 30 zilizopita' => 'Last 30 days', 'Siku 90 zilizopita' => 'Last 90 days', 'Mwaka 1 uliopita' => 'Last year',
        'Wasomaji' => 'Readers', 'Kurasa zilizosomwa na wasomaji wa kipekee, kwa siku' => 'Page reads and unique readers, per day', 'Kurasa zilizosomwa' => 'Page reads', 'Wasomaji wa kipekee' => 'Unique readers',
        'Takwimu za wasomaji zinaanza kuhesabiwa sasa; zitaonekana wasomaji wakifungua hadithi.' => 'Reader stats start counting now; they appear as readers open stories.',
        'Hadithi zilizochapishwa' => 'Published stories', 'Kwenye kipindi ulichochagua' => 'In the selected period', 'Wasomaji wapya' => 'New readers', 'Wasomaji wa kipekee kwenye kipindi' => 'Unique readers in the period',
        'Hadithi kwa lugha' => 'Stories by language', 'Kiswahili dhidi ya English' => 'Kiswahili vs English', 'Maombi ya fursa' => 'Opportunity requests', 'Fursa zilizo wazi dhidi ya zilizofungwa' => 'Open vs closed opportunities',
        'Zilizo wazi' => 'Open', 'Zilizofungwa' => 'Closed', 'Zilizochapishwa na draft, mpya kwanza' => 'Published and draft, newest first', 'Dhibiti' => 'Manage', 'Hali' => 'Status', 'Imechapishwa' => 'Published', 'Fungua' => 'Open',
        'Hakuna hadithi bado.' => 'No stories yet.', 'hadi' => 'to', 'kati ya' => 'of', 'Wasomaji kwa nchi' => 'Readers by country', 'Wasomaji wa kipekee kwa nchi, kwenye kipindi' => 'Unique readers by country, in the period',
        'Nchi zitaonekana baada ya wasomaji kufungua hadithi (zinatambuliwa na mtandao wa Cloudflare wa Laravel Cloud).' => 'Countries appear once readers open stories (detected by the Cloudflare network of Laravel Cloud).',
        'Nyingine' => 'Other', 'Bado hakuna kusoma kulikorekodiwa.' => 'No reads recorded yet.', 'Hadithi kwa mwezi' => 'Stories per month', 'Kiswahili na English zilizochapishwa' => 'Published Kiswahili and English stories',
        'Wasomaji wanaorudi' => 'Returning readers', 'Asilimia ya wasomaji wa kila mwezi: waliorudi dhidi ya wapya' => 'Share of each month\'s readers: returning vs new', 'Wanaorudi' => 'Returning', 'Wapya' => 'New',
        'Hadithi zinazosomwa zaidi' => 'Most read stories', 'Kwa idadi ya views' => 'By number of views', 'Bado hakuna views. Zitaonekana wasomaji wakianza kusoma.' => 'No views yet. They will appear once readers start reading.',
        'Submissions mpya' => 'New submissions', 'Hadithi zilizotumwa na wasomaji zinazosubiri kupitiwa' => 'Stories sent by readers waiting for review', 'Zote' => 'All',
        'Hakuna submission mpya. Zikija, zitaonekana hapa.' => 'No new submissions. They will show up here.', 'Kichwa' => 'Title', 'Lugha' => 'Language', 'Tarehe' => 'Date', 'jumla' => 'total',
        // lists / forms
        'kipengee' => 'item', 'vipengee' => 'items', 'Chuja orodha…' => 'Filter list…', 'Chuja' => 'Filter', 'Ongeza' => 'Add', 'Bado hakuna kitu hapa.' => 'Nothing here yet.',
        'Bofya' => 'Click', 'kuanza.' => 'to start.', 'Vitu vitaonekana hapa vikifika kutoka kwenye site.' => 'Items will appear here when they arrive from the site.',
        'Inatoka…' => 'Signing out…', 'Hariri' => 'Edit', 'Fungua' => 'Open', 'Futa' => 'Delete', 'Ndiyo' => 'Yes', 'Hapana' => 'No', 'Funga' => 'Close', 'Hifadhi' => 'Save', 'Mpya' => 'New',
        'Hadithi:' => 'Story:', 'Tengeneza fursa kutoka kwa hii' => 'Create listing from this', 'Ripoti za tangazo hili:' => 'Reports on this advert:',
        'Fursa haichapishwi hadi' => 'An opportunity is not published until', 'zijazwe.' => 'are filled in.', 'limehifadhiwa privately' => 'stored privately',
        // users
        'Watu wanaoweza kuingia admin, na wanachoweza kufanya.' => 'People who can sign in to admin, and what they can do.', 'Mtumiaji' => 'User', 'Hali' => 'Status',
        'Amezimwa' => 'Disabled', 'Anasubiri kubadilisha nenosiri' => 'Waiting to change password', 'Yuko hai' => 'Active', 'Ruhusa za kila role' => 'Permissions per role', 'Kazi' => 'Task',
        'Hadithi na Series' => 'Stories and Series', 'Heroes, Opportunities, Pages, Team' => 'Heroes, Opportunities, Pages, Team', 'Inbox (submissions)' => 'Inbox (submissions)',
        'Ujumbe na maombi ya fursa' => 'Messages and opportunity requests', 'Jina la kwanza' => 'First name', 'Jina la mwisho' => 'Last name', 'Barua pepe' => 'Email', 'Simu' => 'Phone',
        'Akaunti iko hai (anaweza kuingia)' => 'Account is active (can sign in)', 'Tengeneza akaunti' => 'Create account', 'Badilisha role:' => 'Change role:',
        'Administrator ndiye pekee anayeweza kuongeza watumiaji na kuwapa role. Administrator wa mwisho hawezi kushushwa wala kufutwa.' => 'Only an Administrator can add users and give them roles. The last Administrator cannot be demoted or deleted.',
        'Mtumiaji mpya atapewa nenosiri la muda atakalolazimika kulibadilisha.' => 'The new user gets a temporary password that must be changed on first sign-in.',
        'Nenosiri la sasa' => 'Current password', 'Nenosiri jipya' => 'New password', 'Thibitisha nenosiri jipya' => 'Confirm new password', 'Angalau herufi 10, na namba moja' => 'At least 10 characters, with one number',
        'Hifadhi nenosiri' => 'Save password',
        // messages (controllers)
        'Imehifadhiwa' => 'Saved', 'Imefutwa' => 'Deleted', 'Mtumiaji ameongezwa' => 'User added', 'Role imebadilishwa' => 'Role changed', 'Mtumiaji ameondolewa' => 'User removed',
        'Wasifu umehifadhiwa' => 'Profile saved', 'Nenosiri limebadilishwa' => 'Password changed', 'Tumia nenosiri jipya utakapoingia tena.' => 'Use the new password next time you sign in.',
        'Nenosiri la sasa si sahihi.' => 'The current password is wrong.', 'Nenosiri jipya liwe na angalau herufi 10.' => 'The new password must have at least 10 characters.',
        'Weka angalau namba moja.' => 'Add at least one number.', 'Manenosiri mapya hayafanani.' => 'The new passwords do not match.', 'Nenosiri jipya lazima litofautiane na la sasa.' => 'The new password must differ from the current one.',
        'Nenosiri la muda:' => 'Temporary password:', 'atalazimika kulibadilisha akiingia.' => 'he or she must change it when signing in.', 'Mipango ya barua pepe bado haijawashwa, mpe mwenyewe.' => 'Email is not switched on yet, give it to them yourself.',
        'Administrator wa mwisho hawezi kushushwa wala kuzimwa.' => 'The last Administrator cannot be demoted or disabled.', 'Huwezi kujishusha mwenyewe. Mwombe Administrator mwingine.' => 'You cannot demote yourself. Ask another Administrator.',
        'Huwezi kujifuta mwenyewe.' => 'You cannot delete yourself.', 'Administrator wa mwisho hawezi kufutwa.' => 'The last Administrator cannot be deleted.',
        'Amezimwa (ana hadithi, kwa hiyo hajafutwa kabisa)' => 'Disabled (has stories, so not fully deleted)', 'Fursa haiwezi kuchapishwa hadi "Verified by" na "Verified on" zijazwe.' => 'An opportunity cannot be published until "Verified by" and "Verified on" are filled in.',
        // stories
        'hadithi' => 'stories', 'Hadithi mpya' => 'New story', 'Hariri hadithi' => 'Edit story', 'Hakuna hadithi bado.' => 'No stories yet.', 'Tafuta kichwa…' => 'Search title…',
        'Sehemu zote' => 'All sections', 'Lugha zote' => 'All languages', 'Hali zote' => 'All statuses', 'Sehemu' => 'Section', 'Maelezo' => 'Details', 'Maandishi' => 'Text', 'Zaidi' => 'More',
        'Lugha ya hadithi' => 'Story language', 'Lebo hii inaonekana kwa msomaji' => 'This label is shown to the reader', 'Aina ya maudhui' => 'Content type', 'Picha ya jalada' => 'Cover image',
        'Ukubwa unaopendekezwa 1600×900, si zaidi ya 4MB' => 'Recommended size 1600×900, not more than 4MB', 'Draft tu. Mhariri ndiye anachapisha.' => 'Draft only. The editor publishes.',
        'Muhtasari (mstari mmoja hadi miwili)' => 'Summary (one or two lines)', 'Maandishi ya hadithi' => 'Story text', 'Muda wa kusoma:' => 'Reading time:', 'dakika' => 'min',
        '(unahesabiwa kutoka maneno). Unaweza kutumia HTML rahisi kama' => '(counted from the words). You can use simple HTML such as',
        'Sura namba' => 'Chapter number', 'Tafsiri ya hadithi nyingine (si lazima)' => 'Translation of another story (optional)', 'Maelezo ya Google (meta description)' => 'Google description (meta description)',
        'Alt text ya picha' => 'Image alt text', 'Maelezo ya picha' => 'Image caption', 'Mpiga picha / chanzo' => 'Photographer / source', 'Imedhaminiwa na' => 'Sponsored by',
        'Masahihisho (mstari mmoja: tarehe | maelezo)' => 'Corrections (one per line: date | note)', 'Featured kwenye Home (hadithi moja tu)' => 'Featured on Home (one story only)',
        'Ridhaa ya mwandishi imehifadhiwa (siri)' => 'Author consent on file (private)', 'Hadithi imehifadhiwa' => 'Story saved', 'Hadithi imeongezwa' => 'Story added', 'Hadithi imefutwa' => 'Story deleted',
        'Mwandishi' => 'Author', 'Tafuta kichwa' => 'Search title', 'Hadithi zote' => 'All stories',
        // JS
        'Inapakia…' => 'Loading…', 'Imeshindwa kufungua' => 'Could not open', 'Huna ruhusa ya kufanya hivi.' => 'You do not have permission to do this.', 'Jaribu tena.' => 'Try again.',
        'Kitendo hiki hakirudishwi.' => 'This cannot be undone.', 'Ndiyo, futa' => 'Yes, delete', 'Ghairi' => 'Cancel', 'Haikufanikiwa' => 'It did not work', 'Kuna kosa kwenye fomu' => 'There is a mistake in the form',
        'Angalia sehemu zilizoonyeshwa.' => 'Check the highlighted fields.', 'Hakuna kilichopatikana' => 'Nothing found', 'Nenda' => 'Go', 'kipengee hiki' => 'this item', 'Futa "' => 'Delete "',
    ];

    public static function current(?\Illuminate\Http\Request $r = null): string
    {
        return ($r ?: request())->cookie('nh_lang') === 'en' ? 'en' : 'sw';
    }

    public static function translate(string $text): string
    {
        static $re = null;
        if ($re === null) {
            $keys = array_keys(self::DICT);
            usort($keys, fn ($a, $b) => strlen($b) <=> strlen($a));
            $re = '/(?<![\p{L}])('.implode('|', array_map(fn ($k) => preg_quote($k, '/'), $keys)).')(?![\p{L}])/u';
        }

        return preg_replace_callback($re, fn ($m) => self::DICT[$m[1]], $text) ?? $text;
    }
}
