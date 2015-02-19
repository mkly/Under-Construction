<?php defined('C5_EXECUTE') or die('Access Denied.') ?>
<div class="ccm-dashboard-header-buttons"></div>
<div class="alert" style="background: #F3F3F3">
    <p><?= t('The <strong>admin</strong> super user will always access the full site.') ?><br/>
       <?= t('Allow others to bypass the landing page in <a href="%s">Task Permissions</a> by adjusting the <strong>Bypass Construction Page</strong> permission.', h($permissionsURL)) ?></p>
</div>
<div class="alert" style="background: #F4F8F8; color: #555">
    <p><?= t('Assign the <strong>Guest</strong> user group the <strong>Bypass Construction Page</strong> permission to allow all site visitors to bypass the landing page.') ?></p>
</div>
<form method="post" action="<?= $this->action('update') ?>" class="ccm-dashboard-content-form">
    <fieldset>
        <div class="form-group">
            <?= $form->label('landing-page', t('Select the page that users will be redirected to when visting your site.')) ?>
            <?= $pageSelector->selectPage('landing-page', h($landingPage)) ?>
        </div>
    </fieldset>
    <div class="ccm-dashboard-form-actions-wrapper">
        <div class="ccm-dashboard-form-actions">
            <?= $interface->submit('update', t('Update'), 'right', 'btn-primary') ?>
        </div>
    </div>
    <?= $token->output('update') ?>
</form>
