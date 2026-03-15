<?php

declare(strict_types=1);

/**
 * Plenta Friendly Captcha Bundle for Contao Open Source CMS
 *
 * @copyright     Copyright (c) 2023-2026, Plenta.io
 * @author        Plenta.io <https://plenta.io>
 * @link          https://github.com/plenta/
 */

$GLOBALS['TL_DCA']['tl_form_field']['palettes']['friendly_captcha'] = '{type_legend},type,plenta_fc_hf_name;{fconfig_legend},plenta_fc_version,plenta_fc_theme,plenta_fc_sitekey,plenta_fc_apikey,plenta_fc_puzzle,plenta_fc_eu_endpoint,plenta_fc_friendly_failure,plenta_fc_callback_name;{expert_legend:hide},class,accesskey,tabindex;{template_legend:hide},customTpl;{invisible_legend:hide},invisible';

$GLOBALS['TL_DCA']['tl_form_field']['fields']['plenta_fc_hf_name'] = [
    'inputType' => 'text',
    'mandatory' => true,
    'eval' => ['tl_class' => 'clr w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['plenta_fc_version'] = [
    'inputType' => 'select',
    'options' => ['v1', 'v2'],
    'reference' => &$GLOBALS['TL_LANG']['tl_form_field']['plenta_fc_version_options'],
    'eval' => [
        'tl_class' => 'w50',
        'submitOnChange' => true,
        'mandatory' => true,
        'includeBlankOption' => true,
    ],
    'sql' => "varchar(8) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['plenta_fc_theme'] = [
    'inputType' => 'select',
    'options' => ['auto', 'light', 'dark'],
    'reference' => &$GLOBALS['TL_LANG']['tl_form_field']['plenta_fc_theme_options'],
    'eval' => ['tl_class' => 'w50'],
    'sql' => "varchar(8) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['plenta_fc_sitekey'] = [
    'inputType' => 'text',
    'eval' => ['mandatory' => true, 'tl_class' => 'clr w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['plenta_fc_apikey'] = [
    'inputType' => 'text',
    'eval' => ['mandatory' => true, 'tl_class' => 'w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['plenta_fc_puzzle'] = [
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50'],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['plenta_fc_eu_endpoint'] = [
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50'],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['plenta_fc_friendly_failure'] = [
    'inputType' => 'checkbox',
    'eval' => ['tl_class' => 'w50'],
    'sql' => "char(1) NOT NULL default ''",
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['plenta_fc_callback_name'] = [
    'inputType' => 'text',
    'mandatory' => true,
    'eval' => ['tl_class' => 'clr w50'],
    'sql' => "varchar(64) NOT NULL default ''",
];
