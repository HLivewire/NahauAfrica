<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\DB;

abstract class TestCase extends BaseTestCase
{
    /** Tests that also make sense on a database that holds only the schema. */
    private array $worksWithoutData = [
        'test_guest_is_redirected_to_login', 'test_login_form_rejects_bad_credentials',
        'test_public_api_endpoints_respond', 'test_unknown_api_route_returns_json404',
        'test_protected_routes_need_a_token', 'test_public_pages_load',
        'test_legacy_public_urls_redirect', 'test_dangerous_maintenance_routes_are_gone',
        'test_uploads_reject_executable_files', 'test_svg_with_script_is_rejected', 'test_svg_with_onload_is_rejected', 'test_nclean_strips_dangerous_tags_and_handlers', 'test_image_upload_helper_stores_and_deletes_files',
        'test_search_validates_input_and_works', 'test_public_admin_folder_does_not_shadow_the_admin_route',
    ];

    protected function setUp(): void
    {
        parent::setUp();

        if (in_array($this->name(), $this->worksWithoutData, true)) {
            return;
        }
        if (DB::table('users')->count() === 0 || DB::table('news')->where('status', 1)->count() === 0) {
            $this->markTestSkipped('Database has no demo data. Import nahauafrica.sql into the DB used by the tests to run this test.');
        }
    }
}
