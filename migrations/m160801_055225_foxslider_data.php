<?php
/**
 * This file is part of FoxSlider Module for CMSGears Framework. Please view License file distributed
 * with the source code for license details.
 *
 * @link https://www.cmsgears.org/
 * @copyright Copyright (c) 2015 VulpineCode Technologies Pvt. Ltd.
 */

// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

use cmsgears\core\common\models\entities\Site;
use cmsgears\core\common\models\entities\User;
use cmsgears\core\common\models\entities\Role;
use cmsgears\core\common\models\entities\Permission;

use cmsgears\core\common\utilities\DateUtil;

/**
 * The foxslider data migration inserts the base data required to run the application.
 *
 * @since 1.0.0
 */
class m160801_055225_foxslider_data extends \cmsgears\core\common\base\Migration {

	// Public Variables

	// Private Variables

	private $cmgPrefix;
	private $fxsPrefix;

	private $site;

	private $master;

	public function init() {

		// Fixed
		$this->cmgPrefix = Yii::$app->migration->cmgPrefix;
		$this->fxsPrefix = 'fxs_';

		$this->site		= Site::findBySlug( CoreGlobal::SITE_MAIN );
		$this->master	= User::findByUsername( Yii::$app->migration->getSiteMaster() );
	}

    public function up() {

		// Create RBAC
		$this->insertRolePermission();
    }

	private function insertRolePermission() {

		// Roles
		$superAdminRole	= Role::findBySlugType( 'super-admin', CoreGlobal::TYPE_SYSTEM );
		$adminRole		= Role::findBySlugType( 'admin', CoreGlobal::TYPE_SYSTEM );

		// Permissions
		$columns = [ 'createdBy', 'modifiedBy', 'name', 'slug', 'type', 'icon', 'description', 'createdAt', 'modifiedAt' ];

		$permissions = [
			[ $this->master->id, $this->master->id, 'FoxSlider', 'foxslider', CoreGlobal::TYPE_SYSTEM, NULL, 'The permission foxslider is to manage foxslider from admin.', DateUtil::getDateTime(), DateUtil::getDateTime() ]
		];

		$this->batchInsert( $this->cmgPrefix . 'core_permission', $columns, $permissions );

		$fxsPerm = Permission::findBySlugType( 'foxslider', CoreGlobal::TYPE_SYSTEM );

		// RBAC Mapping
		$columns = [ 'roleId', 'permissionId' ];

		$mappings = [
			[ $superAdminRole->id, $fxsPerm->id ],
			[ $adminRole->id, $fxsPerm->id ]
		];

		$this->batchInsert( $this->cmgPrefix . 'core_role_permission', $columns, $mappings );
	}

    public function down() {

        echo "m160801_055225_foxslider_data will be deleted with m160621_014408_core.\n";
    }

}
