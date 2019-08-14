<?php
class Justuno_Social_Block_Domain extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
{
    /*protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
		//return '<input id="advanced_account_domain" class=" input-text" type="text" value="' . $_SERVER['HTTP_HOST'] . '" name="groups[account][fields][domain][value]" readonly="true"></input>';
    }*/

    public function render(Varien_Data_Form_Element_Abstract $element)
    {

    	$email = Mage::getStoreConfig('justuno/account/email',0);
		$domain = Mage::getStoreConfig('justuno/account/domain',0);
		$jusdata = Mage::getStoreConfig('justuno/account/embed',1);
		//$jusdata = Mage::getStoreConfig('advanced/account/embed');
		if ($jusdata) {
			$jusdata = json_decode($jusdata);
		}
		$dashboard = $jusdata->dashboard;
		
        $this->setElement($element);
        $html = $this->_getHeaderHtml($element);

        if ($email && $jusdata) {
			//$html.= "<span>You are already connected. <a href=".Mage::helper('adminhtml')->getUrl("adminhtml/custom/index/").">Click here to disconnect if necessary</a></span>";
			$html.="<span>Justuno Dashboard <a href=".$dashboard." target='_blank'> Click here </a></span>";
		}
		else{
			$justuno_link = Mage::helper("adminhtml")->getUrl("adminhtml/system_config/edit/section/justuno");
			$html.="<span>Please <a href=".$justuno_link."> click here </a> to first update your magento / justuno app settings.</span>";
	        /*foreach ($element->getSortedElements() as $field) {
	            $html.= $field->toHtml();
	        }*/
        }

        $html .= $this->_getFooterHtml($element);
        return $html;
    }
}