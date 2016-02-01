/* ============================= FoxSlider ============================================== */

--
-- FoxSlider roles and permissions
--

SELECT @rolesadmin := `id` FROM cmg_core_role WHERE slug = 'super-admin';
SELECT @roleadmin := `id` FROM cmg_core_role WHERE slug = 'admin';

INSERT INTO `cmg_core_permission` (`createdBy`,`modifiedBy`,`name`,`slug`,`type`,`icon`,`description`,`createdAt`,`modifiedAt`) VALUES 
	(1,1,'FoxSlider','foxslider','system',NULL,'The permission foxslider is to manage foxslider from admin.','2014-10-11 14:22:54','2014-10-11 14:22:54');

SELECT @permfxs := `id` FROM cmg_core_permission WHERE slug = 'foxslider';

INSERT INTO `cmg_core_role_permission` VALUES 
	(@rolesadmin,@permfxs),
	(@roleadmin,@permfxs);