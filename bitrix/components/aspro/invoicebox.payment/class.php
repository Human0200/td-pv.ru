<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main;
use \Bitrix\Main\Localization\Loc as Loc;

class AsproInvoiceBox extends CBitrixComponent
{
    private $devUrl = 'https://go-dev.invoicebox.ru/module_inbox_auto.u';
    private $prodUrl = 'https://go.invoicebox.ru/module_inbox_auto.u';

	public function onIncludeComponentLang()
	{
		$this->includeComponentLang(basename(__FILE__));
		Loc::loadMessages(__FILE__);
	}

    /**
     * @param $params
     * @return mixed
     */
    public function onPrepareComponentParams($params)
    {
        $params['LANGUAGE_IDENT'] = trim($params['LANGUAGE_IDENT']);
        if (empty($params['LANGUAGE_IDENT']) || ($params['LANGUAGE_IDENT'] != 'EN'))
            $params['LANGUAGE_IDENT'] = 'RUS';

        $params['PARTICIPANT_ID']    = trim($params['PARTICIPANT_ID']);
        $params['PARTICIPANT_IDENT'] = trim($params['PARTICIPANT_IDENT']);
        $params['PARTICIPANT_SIGN']  = trim($params['PARTICIPANT_SIGN']);

        if (!empty($params['REDIRECT_URLS']) && !is_array($params['REDIRECT_URLS']))
            $params['REDIRECT_URLS'] = [$params['REDIRECT_URLS']];

        $params['ORDER_ID'] = trim($params['ORDER_ID']);
        if (empty($params['ORDER_ID']))
            $params['ORDER_ID'] = time();
        
        if (empty($params['ORDER_CURRENCY_IDENT']))
            $params['ORDER_CURRENCY_IDENT'] = 'RUB';
            
        if (empty($params['ORDER_AMOUNT']))
            $params['ORDER_AMOUNT'] = 0;

        $params['ORDER_DESCRIPTION'] = Loc::getMessage('ORDER_PAYMENT');
        $params['ORDER_DESCRIPTION'] .= " #{$params['ORDER_ID']}";
        $params['BODY_TYPE'] = 'PRIVATE';

        $params['URL_RETURNSUCCESS'] = trim($params['URL_RETURNSUCCESS']);
        $params['TESTMODE'] = ($params['TESTMODE'] === 'Y' ? 1 : 0);

        return $params;
    }

    /**
     * @throws Main\SystemException
     */
    protected function checkParams()
    {
        $arCheckParams = $this->getRequiredParams();
        foreach ($this->arParams as $key => $value) {
            if (isset($arCheckParams[$key])) {
                if (empty($this->arParams[$key])) {
                    throw new Main\SystemException(Loc::getMessage('NOT_PASS_FIELD', ['#FIELD#' => Loc::getMessage($key)]));
                }
            }
        }
    }

	protected function getRequiredParams()
	{
        return array_flip(['PARTICIPANT_ID', 'PARTICIPANT_IDENT', 'PARTICIPANT_SIGN', 'ORDER_ID', 'ORDER_DESCRIPTION', 'ORDER_CURRENCY_IDENT']);
	}
    
    protected function getOptionalParams()
	{
        return array_flip(['LANGUAGE_IDENT', 'BODY_TYPE', 'PERSON_NAME', 'PERSON_PHONE', 'PERSON_EMAIL']);
	}
    
    protected function getResult()
	{
        $this->arResult['ORDER_AMOUNT'] = number_format(str_replace(" ", "", $this->arParams['ORDER_AMOUNT']), 2, '.', '');
        $this->arResult['ORDER_AMOUNT_FORMATTED'] = $this->arParams['ORDER_AMOUNT'];

        $this->arResult['PAYMENT_URL'] = $this->arParams['TESTMODE'] ? $this->devUrl : $this->prodUrl;
	}
    
    public function setBasketItems()
	{
        global $arGoods;

        if ($arGoods) {
            $arGoods = $GLOBALS["APPLICATION"]->ConvertCharsetArray($arGoods, SITE_CHARSET, 'UTF-8');
            $itemNo = 0;
            foreach ($arGoods as $basketItem) {
                $itemNo++;
                $this->arResult['FORM_FILEDS']['itransfer_item' . $itemNo . '_name'] = $basketItem['NAME'];
                $this->arResult['FORM_FILEDS']['itransfer_item' . $itemNo . '_quantity'] = $basketItem['QUANTITY'];
                $this->arResult['FORM_FILEDS']['itransfer_item' . $itemNo . '_price'] = $basketItem['PRICE'];
                $this->arResult['FORM_FILEDS']['itransfer_item' . $itemNo . '_type'] = 'commodity';
            };
        }
    }

    protected function setFormField()
	{
        $arFormFields = array_merge($this->getRequiredParams(), $this->getOptionalParams());

        
        $this->arParams = $GLOBALS["APPLICATION"]->ConvertCharsetArray($this->arParams , SITE_CHARSET, 'UTF-8');
        foreach ($arFormFields as $field => $value) {
            if ($field === 'PARTICIPANT_SIGN')
                continue;

            $this->arResult['FORM_FILEDS']['itransfer_'.strtolower($field)] = $this->arParams[$field];
        }
        $this->arResult['FORM_FILEDS']['itransfer_order_amount'] = $this->arResult['ORDER_AMOUNT'];
        $this->arResult['FORM_FILEDS']['itransfer_testmode'] = $this->arParams['TESTMODE'];
        $this->arResult['FORM_FILEDS']['itransfer_participant_sign'] = md5(
            $this->arParams['PARTICIPANT_ID'].
            $this->arParams['ORDER_ID'].
            $this->arResult['ORDER_AMOUNT'].
            $this->arParams['ORDER_CURRENCY_IDENT'].
            $this->arParams['PARTICIPANT_SIGN']
        );
        $this->setBasketItems();
	}

	public function executeComponent()
	{
        try {
            $this->setFrameMode(true);
            $this->checkParams();

            $this->getResult();
            $this->setFormField();

            $this->includeComponentTemplate();

        } catch (Exception $e) {
            ShowError($e->getMessage());
        }
	}
}