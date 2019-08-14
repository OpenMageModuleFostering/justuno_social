<?php
class Justuno_Social_Model_Embed extends Mage_Core_Model_Config_Data
{
    public function save()
    {
    		
			$fdata = array();
			foreach ($this->groups['register']['fields'] as $name=>$field) {
				$fdata[$name] = $field['value'];
			}
			/*if($fdata){
				if(!$fdata['email']) {
					Mage::throwException("Please enter valid email address");
				}
				if(!$fdata['password']) {
					Mage::throwException("Please enter valid pasword");
				}
				if(!$fdata['phone']) {
					Mage::throwException("Please enter phone no");
				}
				if(!$fdata['domain']) {
					Mage::throwException("Please enter domain name");
				}

			}*/
		//print_r($fdata);exit;
			if($fdata['email'] && $fdata['password']){
				/*if ($fdata['embed']) {
					$obj = json_decode($fdata['embed']);
					$fdata['embed'] = $obj->embed;
					$fdata['guid'] = $obj->guid;
				}*/
				$fdata['guid'] = "";
				include_once dirname(__FILE__) . '/JustunoAccess.php';
				$params = array('apiKey'=>JUSTUNO_KEY,
					'email'=>$fdata['email'],
					'domain'=>$fdata['domain'],
					'guid'=>$fdata['guid'],
					'phone'=>$fdata['phone']);
				if($fdata['password'])
					$params['password'] = $fdata['password'];
				$jAccess = new JustunoAccess($params);
				try {
					$justuno = $jAccess->getWidgetConfig();
					$jusdata = array();
					$jusdata['dashboard'] = (string)$jAccess->getDashboardLink();
					$jusdata['guid'] = (string)$justuno['guid'];
					$jusdata['embed'] = (string)$justuno['embed'];
					$embed_db = (string)json_encode($jusdata);
					Mage::getConfig()->saveConfig('justuno/account/embed', $embed_db, 'default', 1);
					Mage::getConfig()->saveConfig('justuno/account/email', $fdata['email'], 'default', 0);
					Mage::getConfig()->saveConfig('justuno/account/password', $fdata['password'], 'default', 0);
					Mage::getConfig()->saveConfig('justuno/account/domain', $fdata['domain'], 'default', 0);

				}
				catch(JustunoAccessException $e) {
					Mage::throwException($e->getMessage());
				}
			}
			$flogindata = array();
			foreach ($this->groups['account']['fields'] as $name=>$field) {
				$flogindata[$name] = $field['value'];
			}
		/*if($flogindata){
			if(!$flogindata['email']) {
				Mage::throwException("Please enter valid email address");
			}
			if(!$flogindata['password']) {
				Mage::throwException("Please enter valid pasword");
			}

		}*/
		if($flogindata['email'] && $flogindata['password']){
			if ($flogindata['embed']) {
				$obj = json_decode($flogindata['embed']);
				$flogindata['embed'] = $obj->embed;
				$flogindata['guid'] = $obj->guid;
			}
			include_once dirname(__FILE__) . '/JustunoAccess.php';
			$login_params = array('apiKey'=>JUSTUNO_KEY,'email'=>$flogindata['email'],'domain'=>'','guid'=>$flogindata['guid']);
			print_r($login_params);
			if($flogindata['password'])
				$login_params['password'] = $flogindata['password'];
			$jAccess = new JustunoAccess($login_params);
			try {
				//$justuno = $jAccess->getWidgetConfig();
				$jusdata = array();
				$jusdata['dashboard'] = (string)$jAccess->getDashboardLink();
				$jusdata['guid'] = (string)$justuno['guid'];
				$jusdata['embed'] = (string)$justuno['embed'];
				$flogin_embed_db = (string)json_encode($jusdata);
				
				$storeCode = 'default';
				$store = Mage::getModel('core/store')->load($storeCode);
				$path = 'justuno/account/embed';
				$config = Mage::getModel('core/config_data');
				$config->setValue($flogin_embed_db);
				$config->setPath($path);
				$config->setScope('default');
				$config->setScopeId($store->getId());
				$config->save();

				//Mage::getConfig()->saveConfig('justuno/account/embed', $flogin_embed_db, 'default', 0);
				Mage::getConfig()->saveConfig('justuno/account/email', $flogindata['email'], 'default', 0);
				Mage::getConfig()->saveConfig('justuno/account/password', $flogindata['password'], 'default', 0);
				Mage::getConfig()->saveConfig('justuno/account/domain', $flogindata['domain'], 'default', 0);
			}
			catch(JustunoAccessException $e) {
				Mage::throwException($e->getMessage());
			}
		}
		return parent::save();
	}
}
