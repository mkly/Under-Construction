<?php
namespace Concrete\Package\UnderConstruction;
defined('C5_EXECUTE') or die('Access Denied.');

use Page;
use Group;
use Events;
use Package;
use Session;
use SinglePage;
use PermissionAccess;
use Permissions;
use TaskPermission;
use Concrete\Core\Routing\Redirect;
use Concrete\Core\Permission\Access\AdminAccess;
use Concrete\Core\Permission\Access\Entity\GroupEntity;
use Concrete\Core\Permission\Key\AdminKey;


class Controller extends Package
{

    protected $pkgHandle = 'under_construction';
    protected $appVersionRequired = '5.7.1';
    protected $pkgVersion = '0.9.0';

    public function getPackageDescription()
    {
        return t('Direct visitors to a custum landing page');
    }

    public function getPackageName()
    {
        return t('Under Construction');
    }

    public function on_start()
    {
        Events::addListener('on_page_view', array($this, 'handlePageView'));
    }

    public function handlePageView($event)
    {
        $page = $event->getPageObject();
        $cID = $this->getConfig()->get('underconstruction.landingPageCID');
        if ($cID == $page->getCollectionID()) {
            return;
        }

        if ($page->isSystemPage() || $page->isAdminArea()) {
            return;
        }

        $perm = new Permissions();
        if ($perm->canBypassConstructionPage()) {
            return;
        }

        $redirectPage = Page::getByID($cID);
        if ($redirectPage->isError()) {
            return;
        }

        $r = Redirect::page($redirectPage, 302);
        $r->send();
        exit;
    }

    public function install()
    {
        $pkg = parent::install();

        /** @todo find config value of this instead of just 1 **/
        $pkg->getConfig()->save('underconstruction.landingPageCID', 1);

        SinglePage::add('/dashboard/system/permissions/under_construction', $pkg);

        $pk = AdminKey::getByHandle('bypass_construction_page');
        if (!$pk) {
            $pk = AdminKey::add(
              'admin',
              'bypass_construction_page',
              t('Bypass Construction Page'),
              t('Can bypass the construction page and see the full site'),
              0,
              0,
              $pkg
            );
        }

        $admins = Group::getByName('Administrators');
        $pae = GroupEntity::getOrCreate($admins);
        $pk = AdminKey::getByHandle('bypass_construction_page');
        $pa = PermissionAccess::create($pk);
        $pa->addListItem($pae);
        $pao = $pk->getPermissionAssignmentObject();
        $pao->assignPermissionAccess($pa);

    }

}
