<?php
class Justuno_Social_Block_Dashboard1 extends Mage_Adminhtml_Block_System_Config_Form_Fieldset
{
    /*protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
		$email = Mage::getStoreConfig('advanced/account/email');
		$domain = Mage::getStoreConfig('advanced/account/domain');
		$jusdata = Mage::getStoreConfig('advanced/account/embed');
		if ($email && $jusdata) {
			$jusdata = json_decode($jusdata);
			include_once realpath(dirname(__FILE__) . '/../Model/JustunoAccess.php');
			$jAccess = new JustunoAccess(array('apiKey'=>JUSTUNO_KEY,'email'=>$email, 'guid'=>$jusdata->guid, 'domain'=>$domain));
			$url = $jAccess->getDashboardLink();
		}
		else {
			$url = 'https://www.justuno.com/dashboard.html?loggedin=true';
		}
		return '<button title="Justuno Dashboard" class="scalable" onClick="window.open(\'' . $url . '\',\'_blank\'); return false;">Justuno Dashboard</button>';
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
			$html.= "<span>You are already connected. <a href=".Mage::helper('adminhtml')->getUrl("adminhtml/custom/index/").">Click here to disconnect if necessary</a></span>";
			//$html.="<br/><span>Justuno Dashboard <a href=".$dashboard." target='_blank'> Click here </a></span>";
		}
		else{
	        foreach ($element->getSortedElements() as $field) {
	            $html.= $field->toHtml();

	        }
	        $html .= $this->_getFooterHtml($element);
        	return $html;
        }

        
    }
}
