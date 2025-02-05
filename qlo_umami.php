<?php

/**
 * Copyright since 2025 Digital Malayali Studio
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to The MIT License (MIT)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/license/mit
 *
 * @author    Digital Malayali Studio https://studio.digitalmalayali.in/
 * @copyright 2025
 * @license   https://opensource.org/license/mit The MIT License (MIT)
 */
if (!defined('_PS_VERSION_')) {
    exit;
}

class Qlo_Umami extends Module
{
    public function __construct()
    {
        $this->name = 'qlo_umami';
        $this->version = '1.0.0';
        $this->ps_versions_compliancy = ['min' => '1.6', 'max' => _PS_VERSION_];
        $this->author = 'Digital Malayali Studio';
        $this->bootstrap = true;
        $this->need_instance = 0;
        $this->tab = 'analytics_stats';

        parent::__construct();

        $this->displayName = $this->l('Umami');
        $this->description = $this->l('Umami is an open-source, simple, fast and privacy-focused alternative to Google Analytics');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall this module?');
    }

    protected function _displayUmami()
    {
        return $this->display(__FILE__, 'info.tpl');
    }


    public function getContent()
    {
        $html = '';

        if (Tools::isSubmit('submit' . $this->name)) {
            $website = Tools::getValue('WEBSITE');
            $websiteId = Tools::getValue('WEBSITE_ID');
            $dataDomains = Tools::getValue('DATA_DOMAINS');
            $dataHostURL = Tools::getValue('DATA_HOST_URL');
            $dataTag = Tools::getValue('DATA_TAG');
            $dataAutoTrack = (int) Tools::getValue('DATA_AUTO_TRACK');
            $trackBackofficeEnabled = (int) Tools::getValue('TRACK_BACKOFFICE');

            if (!$website || !Validate::isGenericName($website)) {
                $html .= $this->displayError($this->l('Enter analytics website'));
            } elseif (!$websiteId || !Validate::isGenericName($websiteId)) {
                $html .= $this->displayError($this->l('Enter website ID'));
            } else {
                Configuration::updateValue('WEBSITE', $website);
                Configuration::updateValue('WEBSITE_ID', $websiteId);
                Configuration::updateValue('DATA_DOMAINS', $dataDomains);
                Configuration::updateValue('DATA_HOST_URL', $dataHostURL);
                Configuration::updateValue('DATA_TAG', $dataTag);
                Configuration::updateValue('DATA_AUTO_TRACK', $dataAutoTrack);
                Configuration::updateValue('TRACK_BACKOFFICE', $trackBackofficeEnabled);

                $html .= $this->displayConfirmation($this->l('Configuration updated'));
            }
        }

        $html .= $this->_displayUmami();

        return $html . $this->displayForm();
    }

    public function displayForm()
    {

        $fieldsForm[0]['form'] = array(
            'legend' => array(
                'title' => $this->l('Configuration'),
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Analytics Website'),
                    'name' => 'WEBSITE',
                    'size' => 20,
                    'placeholder' => 'analytics.example.com',
                    'required' => true,
                    'desc' => $this->l('Enter the domain where the Umami script is hosted. For e.g., if you are using Umami Cloud it will be cloud.umami.is'),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Website ID'),
                    'name' => 'WEBSITE_ID',
                    'size' => 20,
                    'placeholder' => '7717acc9-a15a-4072-a138-d920259276c9',
                    'required' => true,
                    'desc' => $this->l('Enter the website ID.'),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Data Domains'),
                    'name' => 'DATA_DOMAINS',
                    'size' => 20,
                    'placeholder' => 'booking.example.in,shop.example.in',
                    'desc' => $this->l('If you want the tracker to run only on specific domains, enter them above without spaces'),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Data Host URL'),
                    'name' => 'DATA_HOST_URL',
                    'size' => 20,
                    'placeholder' => 'https://data.example.com',
                    'desc' => $this->l('If you want to send the analytics data to another location, enter the URL'),
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Data Tag'),
                    'name' => 'DATA_TAG',
                    'size' => 20,
                    'placeholder' => 'umami-eu',
                    'desc' => $this->l('If you want the tracker to collect events under a specific tag, enter it above'),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Data Auto Track'),
                    'name' => 'DATA_AUTO_TRACK',
                    'desc' => $this->l('Enable or disable the automatic tracking of all pageviews and events'),
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'value' => 1,
                            'label' => $this->l('Yes'),
                        ),
                        array(
                            'value' => 0,
                            'label' => $this->l('No'),
                        ),
                    ),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Enable Back Office Tracking'),
                    'name' => 'TRACK_BACKOFFICE',
                    'desc' => $this->l('Enable or disable the tracking inside the Back Office'),
                    'is_bool' => true,
                    'values' => array(
                        array(
                            'value' => 1,
                            'label' => $this->l('Yes'),
                        ),
                        array(
                            'value' => 0,
                            'label' => $this->l('No'),
                        ),
                    ),
                )
            ),
            'submit' => array(
                'title' => $this->l('Save'),
                'class' => 'btn btn-default pull-right'
            )
        );

        $helper = new HelperForm();

        $helper->submit_action = 'submit' . $this->name;

        $helper->fields_value['WEBSITE'] = Configuration::get('WEBSITE');
        $helper->fields_value['WEBSITE_ID'] = Configuration::get('WEBSITE_ID');
        $helper->fields_value['DATA_DOMAINS'] = Configuration::get('DATA_DOMAINS');
        $helper->fields_value['DATA_HOST_URL'] = Configuration::get('DATA_HOST_URL');
        $helper->fields_value['DATA_TAG'] = Configuration::get('DATA_TAG');
        $helper->fields_value['DATA_AUTO_TRACK'] = Configuration::get('DATA_AUTO_TRACK');
        $helper->fields_value['TRACK_BACKOFFICE'] = Configuration::get('TRACK_BACKOFFICE');

        return $helper->generateForm($fieldsForm);
    }

    public function hookDisplayHeader()
    {
        if (!Configuration::get('WEBSITE')) {
            return '';
        }

        $this->context->smarty->assign(
            array(
                'website' => Configuration::get('WEBSITE'),
                'website_id' => Configuration::get('WEBSITE_ID'),
                'data_domains' => Configuration::get('DATA_DOMAINS'),
                'data_host_url' => Configuration::get('DATA_HOST_URL'),
                'data_tag' => Configuration::get('DATA_TAG'),
                'data_auto_track' => Configuration::get('DATA_AUTO_TRACK'),
            )
        );

        return $this->display(__FILE__, 'qlo_umami.tpl');
    }

    public function hookDisplayBackOfficeHeader()
    {
        if (Configuration::get('TRACK_BACKOFFICE') && Configuration::get('WEBSITE')) {
            $this->context->smarty->assign(array(
                'website' => Configuration::get('WEBSITE'),
                'website_id' => Configuration::get('WEBSITE_ID'),
                'data_domains' => Configuration::get('DATA_DOMAINS'),
                'data_host_url' => Configuration::get('DATA_HOST_URL'),
                'data_tag' => Configuration::get('DATA_TAG'),
                'data_auto_track' => Configuration::get('DATA_AUTO_TRACK'),
            ));

            return $this->display(__FILE__, 'qlo_umami.tpl');
        }

        return '';
    }


    public function install()
    {
        if (
            !parent::install()
            || !$this->registerHook('displayHeader')
            || !$this->registerHook('displayBackOfficeHeader')
            || !Configuration::updateValue('WEBSITE', '')
            || !Configuration::updateValue('WEBSITE_ID', '')
            || !Configuration::updateValue('DATA_DOMAINS', '')
            || !Configuration::updateValue('DATA_HOST_URL', '')
            || !Configuration::updateValue('DATA_TAG', '')
            || !Configuration::updateValue('DATA_AUTO_TRACK', 1)
            || !Configuration::updateValue('TRACK_BACKOFFICE', 0)
        ) {
            return false;
        }

        return true;
    }

    public function uninstall()
    {
        if (
            !parent::uninstall()
            || !$this->unregisterHook('displayHeader')
            || !$this->unregisterHook('displayBackOfficeHeader')
            || !Configuration::deleteByName('WEBSITE')
            || !Configuration::deleteByName('WEBSITE_ID')
            || !Configuration::deleteByName('DATA_DOMAINS')
            || !Configuration::deleteByName('DATA_HOST_URL')
            || !Configuration::deleteByName('DATA_TAG')
            || !Configuration::deleteByName('DATA_AUTO_TRACK')
            || !Configuration::deleteByName('TRACK_BACKOFFICE')
        ) {
            return false;
        }

        return true;
    }
}
