<?php
namespace Concrete\Package\UnderConstruction\Controller\SinglePage\Dashboard\System\Permissions;
defined('C5_EXECUTE') or die('Access Denied.');

use Core;
use Page;
use Package;
use Concrete\Core\Routing\URL;
use Concrete\Core\Page\Controller\DashboardPageController;

class UnderConstruction extends DashboardPageController
{

    public function view()
    {
        $this->set('form', Core::make('helper/form'));
        $this->set('pageSelector', Core::make('helper/form/page_selector'));
        $pkg = Package::getByHandle('under_construction');
        $this->set('landingPage', $pkg->getConfig()->get('underconstruction.landingPageCID'));
        $this->set('permissionsURL', URL::to('/dashboard/system/permissions/tasks'));
    }

    public function update()
    {
        $this->token->validate('update');
        $pkg = Package::getByHandle('under_construction');
        $page = Page::getByID($this->post('landing-page'));
        if ($page->isError()) {
            $this->error->add(t('Invalid Page'));
            return $this->view();
        }
        $pkg->getConfig()->save('underconstruction.landingPageCID', $page->getCollectionID());
        $this->redirect('/dashboard/system/permissions/under_construction/updated');
    }

    public function updated()
    {
        $this->set('message', t('Settings updated'));
        return $this->view();
    }  
}
