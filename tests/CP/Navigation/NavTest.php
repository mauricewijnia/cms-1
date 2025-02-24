<?php

namespace Tests\CP\Navigation;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;
use Statamic\CP\Navigation\NavItem;
use Statamic\Facades;
use Statamic\Facades\CP\Nav;
use Statamic\Facades\File;
use Statamic\Facades\User;
use Tests\FakesRoles;
use Tests\PreventSavingStacheItemsToDisk;
use Tests\TestCase;

class NavTest extends TestCase
{
    use FakesRoles;
    use PreventSavingStacheItemsToDisk;

    protected $shouldPreventNavBeingBuilt = false;

    public function setUp(): void
    {
        parent::setUp();

        Route::any('wordpress-importer', ['as' => 'statamic.cp.wordpress-importer.index']);
        Route::any('security-droids', ['as' => 'statamic.cp.security-droids.index']);

        // TODO: Other tests are leaving behind forms without titles that are causing failures here?
        Facades\Form::shouldReceive('all')->andReturn(collect());
    }

    /** @test */
    public function it_can_build_a_default_nav()
    {
        $expected = collect([
            'Top Level' => ['Dashboard', 'Playground'],
            'Content' => ['Collections', 'Navigation', 'Taxonomies', 'Assets', 'Globals'],
            'Fields' => ['Blueprints', 'Fieldsets'],
            'Tools' => ['Forms', 'Updates', 'Addons', 'Utilities', 'GraphQL'],
            'Users' => ['Users', 'Groups', 'Permissions'],
        ]);

        $this->actingAs(tap(User::make()->makeSuper())->save());

        $nav = $this->build();

        $this->assertEquals($expected->keys(), $nav->keys());
        $this->assertEquals($expected->get('Content'), $nav->get('Content')->map->display()->all());
        $this->assertEquals($expected->get('Fields'), $nav->get('Fields')->map->display()->all());
        $this->assertEquals($expected->get('Tools'), $nav->get('Tools')->map->display()->all());
        $this->assertEquals($expected->get('Users'), $nav->get('Users')->map->display()->all());
    }

    /** @test */
    public function it_can_create_a_nav_item()
    {
        $this->actingAs(tap(User::make()->makeSuper())->save());

        Nav::utilities('Wordpress Importer')
            ->route('wordpress-importer.index')
            ->can('view updates');

        $item = $this->build()->get('Utilities')->last();

        $this->assertEquals('utilities::wordpress_importer', $item->id());
        $this->assertEquals('Utilities', $item->section());
        $this->assertEquals('Wordpress Importer', $item->display());
        $this->assertEquals(config('app.url').'/wordpress-importer', $item->url());
        $this->assertEquals('view updates', $item->authorization()->ability);
        $this->assertEquals('view updates', $item->can()->ability);
        $this->assertNull($item->attributes());
        $this->assertFalse($item->isHidden());
    }

    /** @test */
    public function it_can_more_explicitly_create_a_nav_item()
    {
        $this->actingAs(tap(User::make()->makeSuper())->save());

        Nav::create('R2-D2')
            ->section('Droids')
            ->url('/r2');

        $item = $this->build()->get('Droids')->first();

        $this->assertEquals('Droids', $item->section());
        $this->assertEquals('R2-D2', $item->display());
        $this->assertEquals('http://localhost/r2', $item->url());
    }

    /** @test */
    public function it_can_create_a_nav_item_with_a_more_custom_config()
    {
        $this->actingAs(tap(User::make()->makeSuper())->save());

        Nav::droids('C-3PO')
            ->id('some::custom::id')
            ->active('threepio*')
            ->url('/human-cyborg-relations')
            ->view('cp.nav.importer')
            ->can('index', 'DroidsClass')
            ->attributes(['target' => '_blank', 'class' => 'red']);

        $item = $this->build()->get('Droids')->first();

        $this->assertEquals('some::custom::id', $item->id());
        $this->assertEquals('Droids', $item->section());
        $this->assertEquals('C-3PO', $item->display());
        $this->assertEquals('http://localhost/human-cyborg-relations', $item->url());
        $this->assertEquals('cp.nav.importer', $item->view());
        $this->assertEquals('threepio*', $item->active());
        $this->assertEquals('index', $item->authorization()->ability);
        $this->assertEquals('DroidsClass', $item->authorization()->arguments);
        $this->assertEquals(' target="_blank" class="red"', $item->attributes());
    }

    /** @test */
    public function it_can_create_a_nav_item_with_a_bundled_svg_icon()
    {
        File::put($svg = statamic_path('resources/svg/icons/light/test.svg'), 'the totally real svg');

        $this->actingAs(tap(User::make()->makeSuper())->save());

        Nav::utilities('Test')->icon('test');

        $item = $this->build()->get('Utilities')->last();

        $this->assertEquals('the totally real svg', $item->icon());

        File::delete($svg);
    }

    /** @test */
    public function it_can_create_a_nav_item_with_a_custom_svg_icon()
    {
        $this->actingAs(tap(User::make()->makeSuper())->save());

        Nav::utilities('Test')
            ->icon('<svg><circle cx="50" cy="50" r="40" stroke="black" stroke-width="3" fill="red" /></svg>');

        $item = $this->build()->get('Utilities')->last();

        $this->assertEquals('<svg><circle cx="50" cy="50" r="40" stroke="black" stroke-width="3" fill="red" /></svg>', $item->icon());
    }

    /** @test */
    public function it_can_get_and_modify_an_existing_item()
    {
        $this->actingAs(tap(User::make()->makeSuper())->save());

        Nav::droids('WAC-47')
            ->url('/pit-droid')
            ->icon('<svg>...</svg>');

        Nav::droids('WAC-47')
            ->url('/d-squad');

        $item = $this->build()->get('Droids')->first();

        $this->assertEquals('Droids', $item->section());
        $this->assertEquals('WAC-47', $item->display());
        $this->assertEquals('<svg>...</svg>', $item->icon());
        $this->assertEquals('http://localhost/d-squad', $item->url());
    }

    /** @test */
    public function it_doesnt_build_items_that_the_user_is_not_authorized_to_see()
    {
        $this->setTestRoles(['test' => ['access cp']]);
        $this->actingAs(tap(User::make()->assignRole('test'))->save());

        Nav::theEmpire('Death Star');

        $this->assertEquals('Death Star', $this->build()->get('The Empire')->first()->display());

        Nav::theEmpire('Death Star')
            ->can('view death star');

        $this->assertNull($this->build()->get('The Empire'));
    }

    /** @test */
    public function it_can_create_a_nav_item_with_children()
    {
        $this->actingAs(tap(User::make()->makeSuper())->save());

        Nav::droids('Battle Droids')
            ->url('/battle-droids')
            ->children([
                Nav::item('B1')->url('/b1'),
                Nav::item('B2')->url('/b2'),
                'HK-47' => '/hk-47', // If only specifying display name and URL, can pass key/value pair as well.
            ]);

        $item = $this->build()->get('Droids')->first();

        $this->assertEquals('Battle Droids', $item->display());
        $this->assertEquals('B1', $item->children()->get(0)->display());
        $this->assertEquals('droids::battle_droids::b1', $item->children()->get(0)->id());
        $this->assertEquals('B2', $item->children()->get(1)->display());
        $this->assertEquals('droids::battle_droids::b2', $item->children()->get(1)->id());
        $this->assertEquals('HK-47', $item->children()->get(2)->display());
        $this->assertEquals('droids::battle_droids::hk_47', $item->children()->get(2)->id());

        $this->assertFalse($item->isChild());

        $item->children()->each(function ($item) {
            $this->assertTrue($item->isChild());
        });
    }

    /** @test */
    public function it_sets_parent_icon_on_children()
    {
        File::put($svg = statamic_path('resources/svg/icons/light/droid.svg'), '<svg>droid</svg>');

        $this->actingAs(tap(User::make()->makeSuper())->save());

        Nav::droids('Battle Droids')
            ->url('/battle-droids')
            ->icon('droid')
            ->children([
                Nav::item('B1')->url('/b1'),
                Nav::item('B2')->url('/b2'),
                'HK-47' => '/hk-47', // If only specifying name and URL, can pass key/value pair as well.
            ]);

        $item = $this->build()->get('Droids')->first();

        $this->assertEquals('<svg>droid</svg>', $item->icon());
        $this->assertEquals('<svg>droid</svg>', $item->children()->get(0)->icon());
        $this->assertEquals('<svg>droid</svg>', $item->children()->get(1)->icon());
        $this->assertEquals('<svg>droid</svg>', $item->children()->get(2)->icon());

        File::delete($svg);
    }

    /** @test */
    public function it_doesnt_build_children_that_the_user_is_not_authorized_to_see()
    {
        $this->setTestRoles(['sith' => ['view sith diaries']]);
        $this->actingAs(tap(User::make()->assignRole('sith'))->save());

        Nav::custom('Diaries')
            ->url('/diaries')
            ->children([
                Nav::item('Jedi')->url('/b1')->can('view jedi diaries'),
                Nav::item('Sith')->url('/b2')->can('view sith diaries'),
            ]);

        Nav::custom('Logs')
            ->url('/logs')
            ->children([
                Nav::item('Jedi')->url('/b1')->can('view jedi logs'),
                Nav::item('Sith')->url('/b2')->can('view sith logs'),
            ]);

        $diaries = $this->build()->get('Custom')->first();
        $logs = $this->build()->get('Custom')->last();

        $this->assertCount(1, $diaries->children());
        $this->assertEquals('Sith', $diaries->children()->get(0)->display());
        $this->assertEquals('custom::diaries::sith', $diaries->children()->get(0)->id());

        $this->assertNull($logs->children());
    }

    /** @test */
    public function it_can_create_a_nav_item_with_children_in_a_closure_to_defer_loading_until_they_are_needed()
    {
        $this->markTestSkipped('Getting a NotFoundHttpException, even though I\'m registering route?');

        $this
            ->actingAs(User::make()->makeSuper())
            ->get(cp_route('security-droids.index'))
            ->assertStatus(200);

        $item = Nav::droids('Security Droids')
            ->url('/security-droids')
            ->children(function () {
                return [
                    'IG-86' => '/ig-86',
                    'K-2SO' => '/k-2so',
                ];
            });

        $this->assertEquals('Security Droids', $item->display());
        $this->assertTrue(is_callable($item->children()));

        $item = $this->build()->get('Droids')->first();

        $this->assertEquals('Security Droids', $item->display());
        $this->assertFalse(is_callable($item->children()));
        $this->assertEquals('IG-86', $item->children()->get(0)->display());
        $this->assertEquals('droids::security_droids::ig_86', $item->children()->get(0)->id());
        $this->assertEquals('K-2SO', $item->children()->get(1)->display());
        $this->assertEquals('droids::security_droids::k_2so', $item->children()->get(1)->id());
    }

    /** @test */
    public function it_can_resolve_its_children_from_closure()
    {
        $this->actingAs(tap(User::make()->makeSuper())->save());

        $item = Nav::droids('Security Droids')
            ->children(function () {
                return [
                    'IG-86' => '/ig-86',
                    'K-2SO' => '/k-2so',
                ];
            });

        $this->assertEquals('Security Droids', $item->display());
        $this->assertTrue(is_callable($item->children()));

        $item->resolveChildren();

        $this->assertEquals('Security Droids', $item->display());
        $this->assertFalse(is_callable($item->children()));
        $this->assertEquals('IG-86', $item->children()->get(0)->display());
        $this->assertEquals('droids::security_droids::ig_86', $item->children()->get(0)->id());
        $this->assertEquals('K-2SO', $item->children()->get(1)->display());
        $this->assertEquals('droids::security_droids::k_2so', $item->children()->get(1)->id());
    }

    /** @test */
    public function it_can_remove_a_nav_section()
    {
        $this->actingAs(tap(User::make()->makeSuper())->save());

        Nav::ships('Millenium Falcon')
            ->url('/millenium-falcon')
            ->icon('falcon');

        Nav::ships('X-Wing')
            ->url('/x-wing')
            ->icon('x-wing');

        $this->assertCount(2, $this->build()->get('Ships'));

        Nav::remove('Ships');

        $this->assertNull($this->build()->get('Ships'));
    }

    /** @test */
    public function it_can_remove_a_specific_nav_item()
    {
        $this->actingAs(tap(User::make()->makeSuper())->save());

        Nav::ships('Y-Wing')
            ->url('/y-wing')
            ->icon('y-wing');

        Nav::ships('A-Wing')
            ->url('/a-wing')
            ->icon('a-wing');

        $this->assertCount(2, $this->build()->get('Ships'));

        Nav::remove('Ships', 'Y-Wing');

        $this->assertCount(1, $ships = $this->build()->get('Ships'));
        $this->assertEquals('A-Wing', $ships->first()->display());
    }

    /** @test */
    public function it_can_use_extend_to_defer_until_after_statamic_core_nav_items_are_built()
    {
        $this->actingAs(tap(User::make()->makeSuper())->save());

        Nav::extend(function ($nav) {
            $nav->jedi('Yoda')->url('/yodas-hut')->icon('green-but-cute-alien');
        });

        $this->assertEmpty(Nav::items());

        $nav = $this->build();

        $this->assertEmpty(Nav::items());
        $this->assertContains('Yoda', $this->build()->get('Jedi')->map->display());
        $this->assertEquals('Jedi', $this->build()->keys()->last());
    }

    /** @test */
    public function it_can_use_extend_to_remove_a_default_statamic_nav_item()
    {
        $this->actingAs(tap(User::make()->makeSuper())->save());

        $nav = Nav::build();

        $this->assertContains('Collections', $this->build()->get('Content')->map->display());

        Nav::extend(function ($nav) {
            $nav->remove('Content', 'Collections');
        });

        $this->assertNotContains('Collections', $this->build()->get('Content')->map->display());
    }

    /** @test */
    public function it_checks_if_active()
    {
        $hello = Nav::create('hello')->url('http://localhost/cp/hello');
        $helloWithQueryParams = Nav::create('helloWithAnchor')->url('http://localhost/cp/hello?params');
        $helloWithAnchor = Nav::create('helloWithAnchor')->url('http://localhost/cp/hello#anchor');
        $hell = Nav::create('hell')->url('http://localhost/cp/hell');
        $localNotCp = Nav::create('localNotCp')->url('/dashboard');
        $external = Nav::create('external')->url('http://external.com');
        $externalSecure = Nav::create('externalSecure')->url('https://external.com');

        Request::swap(Request::create('http://localhost/cp/hell'));
        $this->assertFalse($hello->isActive());
        $this->assertFalse($helloWithQueryParams->isActive());
        $this->assertFalse($helloWithAnchor->isActive());
        $this->assertTrue($hell->isActive());
        $this->assertFalse($localNotCp->isActive());
        $this->assertFalse($external->isActive());
        $this->assertFalse($externalSecure->isActive());

        Request::swap(Request::create('http://localhost/cp/hello'));
        $this->assertTrue($hello->isActive());
        $this->assertTrue($helloWithQueryParams->isActive());
        $this->assertTrue($helloWithAnchor->isActive());
        $this->assertFalse($hell->isActive());
        $this->assertFalse($localNotCp->isActive());
        $this->assertFalse($external->isActive());
        $this->assertFalse($externalSecure->isActive());

        Request::swap(Request::create('http://localhost/cp/hell/test'));
        $this->assertFalse($hello->isActive());
        $this->assertFalse($helloWithQueryParams->isActive());
        $this->assertFalse($helloWithAnchor->isActive());
        $this->assertFalse($hell->isActive());
        $this->assertFalse($localNotCp->isActive());
        $this->assertFalse($external->isActive());
        $this->assertFalse($externalSecure->isActive());

        Request::swap(Request::create('http://localhost/cp/hello/test'));
        $this->assertFalse($hello->isActive());
        $this->assertFalse($helloWithQueryParams->isActive());
        $this->assertFalse($helloWithAnchor->isActive());
        $this->assertFalse($hell->isActive());
        $this->assertFalse($localNotCp->isActive());
        $this->assertFalse($external->isActive());
        $this->assertFalse($externalSecure->isActive());

        Request::swap(Request::create('http://localhost/cp/hello?params'));
        $this->assertTrue($hello->isActive());
        $this->assertTrue($helloWithQueryParams->isActive());
        $this->assertTrue($helloWithAnchor->isActive());
        $this->assertFalse($hell->isActive());
        $this->assertFalse($localNotCp->isActive());
        $this->assertFalse($external->isActive());
        $this->assertFalse($externalSecure->isActive());

        Request::swap(Request::create('http://localhost/cp/hello#anchor'));
        $this->assertTrue($hello->isActive());
        $this->assertTrue($helloWithQueryParams->isActive());
        $this->assertTrue($helloWithAnchor->isActive());
        $this->assertFalse($hell->isActive());
        $this->assertFalse($localNotCp->isActive());
        $this->assertFalse($external->isActive());
        $this->assertFalse($externalSecure->isActive());
    }

    /** @test */
    public function it_checks_if_has_active_children()
    {
        $collections = Nav::content('Collections')
            ->url('http://localhost/cp/collections')
            ->children(function () use (&$pages, &$articles) {
                return [
                    $pages = Nav::item('Pages')->url('/cp/collections/pages'),
                    $articles = Nav::item('Articles')->url('/cp/collections/articles'),
                ];
            });

        Request::swap(Request::create('http://localhost/cp/collections/articles'));
        $this->assertTrue($collections->isActive());
        $this->assertFalse($pages->isActive());
        $this->assertTrue($articles->isActive());
    }

    /** @test */
    public function it_can_get_has_active_children_status_with_custom_resolve_children_pattern()
    {
        $collections = Nav::content('Custom Collections Url')
            ->url('http://localhost/cp/custom/url')
            ->active('collections*')
            ->children(function () use (&$pages, &$articles) {
                return [
                    $pages = Nav::item('Pages')->url('/cp/collections/pages'),
                    $articles = Nav::item('Articles')->url('/cp/collections/articles'),
                ];
            });

        Request::swap(Request::create('http://localhost/cp/collections/articles'));
        $this->assertTrue($collections->isActive());
        $this->assertFalse($pages->isActive());
        $this->assertTrue($articles->isActive());
    }

    /**
     * @deprecated
     *
     * @test
     */
    public function it_can_get_has_active_children_status_with_deprecated_active_pattern()
    {
        $collections = Nav::content('Custom Collections Url')
            ->url('http://localhost/cp/custom/url')
            ->active('collections*')
            ->children(function () use (&$pages, &$articles) {
                return [
                    $pages = Nav::item('Pages')->url('/cp/collections/pages'),
                    $articles = Nav::item('Articles')->url('/cp/collections/articles'),
                ];
            });

        Request::swap(Request::create('http://localhost/cp/collections/articles'));
        $this->assertTrue($collections->isActive());
        $this->assertFalse($pages->isActive());
        $this->assertTrue($articles->isActive());
    }

    /** @test */
    public function it_sets_the_url()
    {
        tap(Nav::create('external-absolute')->url('http://domain.com'), function ($nav) {
            $this->assertEquals('http://domain.com', $nav->url());
            $this->assertNull($nav->active());
        });

        tap(Nav::create('site-relative')->url('/foo/bar'), function ($nav) {
            $this->assertEquals('http://localhost/foo/bar', $nav->url());
            $this->assertNull($nav->active());
        });

        tap(Nav::create('cp-relative')->url('foo/bar'), function ($nav) {
            $this->assertEquals('http://localhost/cp/foo/bar', $nav->url());
            $this->assertEquals('foo/bar(/(.*)?|$)', $nav->active());
        });
    }

    /** @test */
    public function it_gets_a_cleaner_editable_version_of_the_url()
    {
        tap(Nav::create('external-absolute')->url('http://domain.com'), function ($nav) {
            $this->assertEquals('http://domain.com', $nav->editableUrl());
        });

        tap(Nav::create('site-relative')->url('/foo/bar'), function ($nav) {
            $this->assertEquals('/foo/bar', $nav->editableUrl());
        });

        tap(Nav::create('cp-relative')->url('foo/bar'), function ($nav) {
            $this->assertEquals('/cp/foo/bar', $nav->editableUrl());
        });
    }

    /** @test */
    public function it_does_not_automatically_add_a_resolve_children_pattern_when_setting_url_if_one_is_already_defined()
    {
        $nav = Nav::create('cp-relative')->active('foo.*')->url('foo/bar');
        $this->assertEquals('http://localhost/cp/foo/bar', $nav->url());
        $this->assertEquals('foo.*', $nav->active());
    }

    /** @test */
    public function it_doesnt_build_with_hidden_items()
    {
        $this->actingAs(tap(User::make()->makeSuper())->save());

        Nav::testSection('Visible Item');
        Nav::testSection('Hidden Item')->hidden(true);

        $this->assertCount(1, $this->build()->get('Test Section'));
        $this->assertEquals('Visible Item', $this->build()->get('Test Section')->first()->display());
    }

    /** @test */
    public function it_doesnt_build_sections_containing_only_hidden_items()
    {
        $this->actingAs(tap(User::make()->makeSuper())->save());

        Nav::testSection('Hidden Item')->hidden(true);

        $this->assertNull($this->build()->get('Test Section'));
    }

    /** @test */
    public function it_can_build_with_hidden_items()
    {
        $this->actingAs(tap(User::make()->makeSuper())->save());

        Nav::testSection('Hidden Item')->hidden(true);

        $items = Nav::build(true, true)->pluck('items', 'display')->get('Test Section');

        $this->assertCount(1, $items);
        $this->assertEquals('Hidden Item', $items->first()->display());
        $this->assertTrue($items->first()->isHidden());
    }

    /** @test */
    public function it_hides_items_after_calling_with_hidden()
    {
        $this->actingAs(tap(User::make()->makeSuper())->save());

        Nav::testSection('Visible Item');
        Nav::testSection('Hidden Item')->hidden(true);

        // Calling `withHidden()` should clone the instance, so that we don't update the singleton bound to the facade
        $this->assertCount(2, Nav::build(true, true)->pluck('items', 'display')->get('Test Section'));

        // Which means this should hide the hidden item again
        $this->assertCount(1, $this->build()->get('Test Section'));
        $this->assertEquals('Visible Item', $this->build()->get('Test Section')->first()->display());
    }

    /** @test */
    public function it_can_preserve_current_id_to_prevent_dynamic_id_generation()
    {
        $item = Nav::droids('3PO');

        $this->assertEquals('droids::3po', $item->id());

        $item->section('Droids Preserved')->display('R2');

        // We should see the ID generate dynamically off the section and display
        $this->assertEquals('droids_preserved::r2', $item->id());

        $final = $item->preserveCurrentId()->section('CHANGED')->display('CHANGED');

        // We should not see the ID generate dynamically, due to the `preserveCurrentId()` call
        $this->assertSame($final, $item);
        $this->assertEquals('droids_preserved::r2', $item->id());
    }

    /** @test */
    public function it_can_sync_original_state_to_original_property()
    {
        $item = Nav::droids('C-3PO')
            ->id('some::custom::id')
            ->url('/human-cyborg-relations')
            ->children([
                Nav::item('B1')->url('/b1'),
                Nav::item('B2')->url('/b2'),
            ]);

        $this->assertNull($item->original());

        $item
            ->syncOriginal()
            ->display('Changed Display')
            ->id('changed::id')
            ->url('/changed-url')
            ->children([
                Nav::item('B3')->url('/b3'),
                Nav::item('B4')->url('/b4'),
            ]);

        $this->assertInstanceOf(NavItem::class, $item->original());

        $this->assertEquals('Changed Display', $item->display());
        $this->assertEquals('C-3PO', $item->original()->display());

        $this->assertEquals('changed::id', $item->id());
        $this->assertEquals('some::custom::id', $item->original()->id());

        $this->assertEquals(['B3', 'B4'], $item->children()->map->display()->all());
        $this->assertEquals(['B1', 'B2'], $item->original()->children()->map->display()->all());
    }

    /** @test */
    public function it_resolves_children_on_synced_original_nav_item()
    {
        $item = Nav::droids('C-3PO')->children(function () {
            return [
                Nav::item('B1')->url('/b1'),
                Nav::item('B2')->url('/b2'),
            ];
        });

        $this->assertNull($item->original());
        $this->assertTrue(is_callable($item->children()));

        $item
            ->syncOriginal()
            ->children(function () {
                return [
                    Nav::item('B3')->url('/b3'),
                    Nav::item('B4')->url('/b4'),
                ];
            });

        $this->assertInstanceOf(NavItem::class, $item->original());
        $this->assertTrue(is_callable($item->children()));
        $this->assertTrue(is_callable($item->original()->children()));

        $item->resolveChildren();

        $this->assertFalse(is_callable($item->children()));
        $this->assertFalse(is_callable($item->original()->children()));
        $this->assertEquals(['B3', 'B4'], $item->children()->map->display()->all());
        $this->assertEquals(['B1', 'B2'], $item->original()->children()->map->display()->all());
        $this->assertEquals(['Droids', 'Droids'], $item->original()->children()->map->section()->all());

        $item->children()->each(function ($item) {
            $this->assertInstanceOf(NavItem::class, $item->original());
        });
    }

    /** @test */
    public function it_can_call_name_alias_for_backwards_compatibility()
    {
        $this->actingAs(tap(User::make()->makeSuper())->save());

        Nav::droids('C-3PO')->name('NOT 3PO');

        $item = $this->build()->get('Droids')->first();

        $this->assertEquals('NOT 3PO', $item->name());
    }

    /** @test */
    public function it_can_rebuild_from_fresh_slate()
    {
        $this->actingAs(tap(User::make()->makeSuper())->save());

        // Ensure this extension gets applied on top of a fresh core nav state
        Nav::extend(function ($nav) {
            $nav->jedi('Yoda '.rand()); // This `rand()` call forces a new nav item to be created
        });

        $this->assertEmpty(Nav::items());

        Nav::build();

        $this->assertEmpty(Nav::items());
        $this->assertCount(1, $this->build()->get('Jedi')->map->display());
    }

    /** @test */
    public function it_ensures_top_level_section_is_always_built_when_building_with_hidden()
    {
        $this->actingAs(tap(User::make()->makeSuper())->save());

        Nav::extend(function ($nav) {
            $nav->remove('Top Level', 'Dashboard'); // Remove default top level dashboard item
        });

        $nav = Nav::build(true, true)->pluck('items', 'display');

        $this->assertTrue($nav->has('Top Level'));
        $this->assertCount(0, $nav->get('Top Level'));
    }

    protected function build()
    {
        return Nav::build()->pluck('items', 'display');
    }
}
