<?php
// CMG Imports
use cmsgears\core\common\config\CoreGlobal;

class m160623_055133_foxslider extends \yii\db\Migration {

	// Public Variables

	public $fk;
	public $options;

	// Private Variables

	private $cmgPrefix;
	private $fxsPrefix;

	public function init() {

		// Fixed
		$this->cmgPrefix	= 'cmg_';
		$this->fxsPrefix	= 'fxs_';

		// Get the values via config
		$this->fk			= Yii::$app->cmgMigration->isFk();
		$this->options		= Yii::$app->cmgMigration->getTableOptions();

		// Default collation
		if( $this->db->driverName === 'mysql' ) {

			$this->options = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
		}
	}

    public function up() {

		// Slider
		$this->upSlider();

		// Slide
		$this->upSlide();

		if( $this->fk ) {

			$this->generateForeignKeys();
		}
    }

	private function upSlider() {

        $this->createTable( $this->fxsPrefix . 'slider', [
			'id' => $this->bigPrimaryKey( 20 ),
			'createdBy' => $this->bigInteger( 20 )->notNull(),
			'modifiedBy' => $this->bigInteger( 20 ),
			'name' => $this->string( CoreGlobal::TEXT_LARGE )->notNull(),
			'slug' => $this->string( CoreGlobal::TEXT_XLARGE )->notNull(),
			'description' => $this->string( CoreGlobal::TEXT_XLARGE )->defaultValue( null ),
			'fullPage' => $this->boolean()->notNull()->defaultValue( false ),
			'width' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'height' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'slideWidth' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'slideHeight' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'scrollAuto' => $this->boolean()->notNull()->defaultValue( false ),
			'scrollType' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'circular' => $this->boolean()->notNull()->defaultValue( false ),
			'createdAt' => $this->dateTime()->notNull(),
			'modifiedAt' => $this->dateTime(),
			'data' => $this->text()
        ], $this->options );

        // Index for columns creator and modifier
		$this->createIndex( 'idx_' . $this->fxsPrefix . 'slider_creator', $this->fxsPrefix . 'slider', 'createdBy' );
		$this->createIndex( 'idx_' . $this->fxsPrefix . 'slider_modifier', $this->fxsPrefix . 'slider', 'modifiedBy' );
	}

	private function upSlide() {

        $this->createTable( $this->fxsPrefix . 'slide', [
			'id' => $this->bigPrimaryKey( 20 ),
			'sliderId' => $this->bigInteger( 20 )->notNull(),
			'imageId' => $this->bigInteger( 20 ),
			'name' => $this->string( CoreGlobal::TEXT_LARGE )->notNull(),
			'description' => $this->string( CoreGlobal::TEXT_XLARGE )->defaultValue( null ),
			'url' => $this->string( CoreGlobal::TEXT_XLARGE )->defaultValue( null ),
			'order' => $this->smallInteger( 6 )->defaultValue( 0 ),
			'content' => $this->text()
        ], $this->options );

        // Index for columns creator and modifier
		$this->createIndex( 'idx_' . $this->fxsPrefix . 'slide_slider', $this->fxsPrefix . 'slide', 'sliderId' );
		$this->createIndex( 'idx_' . $this->fxsPrefix . 'slide_image', $this->fxsPrefix . 'slide', 'imageId' );
	}

	private function generateForeignKeys() {

		// Slider
        $this->addForeignKey( 'fk_' . $this->fxsPrefix . 'slider_creator', $this->fxsPrefix . 'slider', 'createdBy', $this->cmgPrefix . 'core_user', 'id', 'RESTRICT' );
		$this->addForeignKey( 'fk_' . $this->fxsPrefix . 'slider_modifier', $this->fxsPrefix . 'slider', 'modifiedBy', $this->cmgPrefix . 'core_user', 'id', 'SET NULL' );

		// Slide
        $this->addForeignKey( 'fk_' . $this->fxsPrefix . 'slide_slider', $this->fxsPrefix . 'slide', 'sliderId', $this->fxsPrefix . 'slider', 'id', 'CASCADE' );
		$this->addForeignKey( 'fk_' . $this->fxsPrefix . 'slide_image', $this->fxsPrefix . 'slide', 'imageId', $this->cmgPrefix . 'core_file', 'id', 'SET NULL' );
	}

    public function down() {

		if( $this->fk ) {

			$this->dropForeignKeys();
		}

        $this->dropTable( $this->fxsPrefix . 'slider' );
		$this->dropTable( $this->fxsPrefix . 'slide' );
    }

	private function dropForeignKeys() {

		// Slider
        $this->dropForeignKey( 'fk_' . $this->fxsPrefix . 'slider_creator', $this->fxsPrefix . 'slider' );
		$this->dropForeignKey( 'fk_' . $this->fxsPrefix . 'slider_modifier', $this->fxsPrefix . 'slider' );

		// Slide
        $this->dropForeignKey( 'fk_' . $this->fxsPrefix . 'slide_slider', $this->fxsPrefix . 'slide' );
		$this->dropForeignKey( 'fk_' . $this->fxsPrefix . 'slide_image', $this->fxsPrefix . 'slide' );
	}
}

?>