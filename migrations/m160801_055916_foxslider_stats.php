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

use cmsgears\core\common\models\resources\ModelStats;

// FXS Imports
use foxslider\common\models\base\FxsTables;

/**
 * The foxslider stats migration insert the default row count for all the tables available in
 * foxslider module. A scheduled console job can be executed to update these stats.
 *
 * @since 1.0.0
 */
class m160801_055916_foxslider_stats extends \cmsgears\core\common\base\Migration {

	// Public Variables

	public $options;

	// Private Variables

	private $cmgPrefix;
	private $fxsPrefix;

	public function init() {

		// Table prefix
		$this->cmgPrefix = Yii::$app->migration->cmgPrefix;
		$this->fxsPrefix = 'fxs_';

		// Get the values via config
		$this->options = Yii::$app->migration->getTableOptions();

		// Default collation
		if( $this->db->driverName === 'mysql' ) {

			$this->options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}
	}

	public function up() {

		// Table Stats
		$this->insertTables();
	}

	private function insertTables() {

		$columns = [ 'parentId', 'parentType', 'name', 'type', 'count' ];

		$tableData = [
			[ 1, CoreGlobal::TYPE_SITE, $this->fxsPrefix . 'slider', 'rows', 0 ],
			[ 1, CoreGlobal::TYPE_SITE, $this->fxsPrefix . 'slide', 'rows', 0 ]
		];

		$this->batchInsert( $this->cmgPrefix . 'core_model_stats', $columns, $tableData );
	}

	public function down() {

		ModelStats::deleteByTable( FxsTables::getTableName( FxsTables::TABLE_SLIDER ) );
		ModelStats::deleteByTable( FxsTables::getTableName( FxsTables::TABLE_SLIDE ) );
	}

}
