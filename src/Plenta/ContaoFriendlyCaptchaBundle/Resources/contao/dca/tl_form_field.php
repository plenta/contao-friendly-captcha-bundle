<?php

declare(strict_types=1);

/**
 * Plenta Friendly Captcha Bundle for Contao Open Source CMS
 *
 * @copyright     Copyright (c) 2023, Plenta.io
 * @author        Plenta.io <https://plenta.io>
 * @link          https://github.com/plenta/
 */

$GLOBALS['TL_DCA']['tl_form_field']['palettes']['friendly_captcha'] = '{type_legend},type;{fconfig_legend},plenta_fc_sitekey,plenta_fc_apikey,plenta_fc_hf_name,plenta_fc_callback_name,plenta_fc_dark_mode,plenta_fc_eu_endpoint,plenta_fc_friendly_failure;{expert_legend:hide},class,accesskey,tabindex;{template_legend:hide},customTpl;{invisible_legend:hide},invisible';

$GLOBALS['TL_DCA']['tl_form_field']['fields']['plenta_fc_sitekey'] = [
    'exclude' => true,
    'inputType' => 'text',
    'mandatory' => true,
    'eval' => ['tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['plenta_fc_apikey'] = [
    'exclude' => true,
    'inputType' => 'text',
    'mandatory' => true,
    'eval' => ['tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['plenta_fc_friendly_failure'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50'],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['plenta_fc_dark_mode'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50'],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['plenta_fc_eu_endpoint'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50'],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['plenta_fc_hf_name'] = [
    'exclude' => true,
    'inputType' => 'text',
    'mandatory' => true,
    'eval' => ['tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['plenta_fc_callback_name'] = [
    'exclude' => true,
    'inputType' => 'text',
    'mandatory' => true,
    'eval' => ['tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];
