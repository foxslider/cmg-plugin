<?php
// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\models\entities\Site;
use cmsgears\core\common\models\entities\User;
use cmsgears\core\common\models\entities\Role;
use cmsgears\core\common\models\entities\Permission;

use cmsgears\core\common\utilities\DateUtil;

class m160623_055225_foxslider_data extends \yii\db\Migration {

	// Private Variables

	private $cmgPrefix;
	private $fxsPrefix;

	private $site;

	private $master;

	public function init() {

		// Fixed
		$this->cmgPrefix	= 'cmg_';
		$this->fxsPrefix	= 'fxs_';

		$this->site		= Site::findBySlug( CoreGlobal::SITE_MAIN );
		$this->master	= User::findByUsername( 'demomaster' );
	}

    public function up() {

		// Create RBAC
		$this->insertRolePermission();
    }

	private function insertRolePermission() {

		// Roles

		$superAdminRole		= Role::findBySlug( 'super-admin' );
		$adminRole			= Role::findBySlug( 'admin' );

		// Permissions

		$columns = [ 'createdBy', 'modifiedBy', 'name', 'slug', 'type', 'icon', 'description', 'createdAt', 'modifiedAt' ];

		$permissions = [
			[ $this->master->id, $this->master->id, 'FoxSlider', 'foxslider', CoreGlobal::TYPE_SYSTEM, NULL, 'The permission foxslider is to manage foxslider from admin.', DateUtil::getDateTime(), DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->cmgPrefix . 'core_permission', $columns, $permissions );

		$fxsPerm			= Permission::findBySlug( 'foxslider' );

		// RBAC Mapping

		$columns = [ 'roleId', 'permissionId' ];

		$mappings = [
			[ $superAdminRole->id, $fxsPerm->id ],
			[ $adminRole->id, $fxsPerm->id ]
		];

		$this->batchInsert( $this->cmgPrefix . 'core_role_permission', $columns, $mappings );
	}

    public function down() {

        echo "m160623_055225_foxslider_data will be deleted with m160621_014408_core.\n";
    }
}

?>