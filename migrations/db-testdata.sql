/* == Reserved Id's - 1501 to 1550 == */

/* ============================= FoxSlider ============================================== */

--
-- Dumping data for table `cmg_role`
--

INSERT INTO `cmg_role` VALUES 
	(1501,1,1,'Slider Manager','The role Slider Manager is limited to manage sliders from admin.','/dashboard',0,'2014-10-11 14:22:54','2014-10-11 14:22:54');

--
-- Dumping data for table `cmg_permission`
--

INSERT INTO `cmg_permission` VALUES 
	(1501,1,1,'slider','The permission slider is to manage slider from admin.','2014-10-11 14:22:54','2014-10-11 14:22:54');

--
-- Dumping data for table `cmg_role_permission`
--

INSERT INTO `cmg_role_permission` VALUES 
	(1,1501),
	(2,1501),
	(1501,1501);