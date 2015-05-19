# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.6.24)
# Database: bbcms
# Generation Time: 2015-05-19 21:56:10 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table nodes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `nodes`;

CREATE TABLE `nodes` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(11) DEFAULT 'text',
  `name` varchar(64) DEFAULT NULL,
  `content` longtext,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

LOCK TABLES `nodes` WRITE;
/*!40000 ALTER TABLE `nodes` DISABLE KEYS */;

INSERT INTO `nodes` (`id`, `type`, `name`, `content`)
VALUES
	(1,'text','main-content','<div><i>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut id orci nulla, vel rutrum enim. Vestibulum fringilla tempor dolor eget accumsan. Nulla facilisi. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Nulla a sem ligula, eu hendrerit est. Vestibulum ultrices tempus arcu. Nulla tellus lectus, luctus eu ornare vel, dictum ut eros. Nulla ac tellus ut tellus pharetra faucibus. Etiam auctor condimentum orci, sed dignissim justo facilisis id. Vivamus metus neque, consectetur sit amet rhoncus sed, gravida a quam. Pellentesque id mauris leo. Sed suscipit, tellus vel gravida aliquet, tortor lorem sagittis felis, ac auctor ante nisl sed elit.</i></div><div><br></div><div>Morbi id diam et turpis vulputate vestibulum id nec leo. Duis quis tellus lectus, sed tempor risus. In et mi enim, sed pellentesque leo. Curabitur quis metus magna, vel egestas urna. Donec lobortis nulla non felis ullamcorper eu bibendum metus ullamcorper. Etiam dapibus, mi ornare pellentesque auctor, sapien orci dapibus arcu, quis aliquam erat tellus sed elit. Integer euismod sollicitudin dui, eget volutpat erat egestas in. Nulla volutpat tortor sagittis nunc adipiscing sed venenatis velit pellentesque. Mauris eu diam vel tortor convallis tincidunt eget a nunc. Nulla consectetur, libero in facilisis tempus, felis velit vulputate justo, non tempus massa ligula sit amet magna. Morbi in aliquam sapien. Nulla commodo, justo ut tempus dapibus, est velit dictum erat, vel gravida ante risus ut nisi. Suspendisse potenti. Aliquam elementum, enim et commodo scelerisque, nisi mi vehicula sapien, et viverra diam velit vitae risus. Nullam sagittis odio id odio elementum egestas et dapibus tortor. In ac arcu enim, non laoreet ligula.</div><div><br></div><div>In interdum facilisis elit sit amet consectetur. Sed rhoncus velit eu justo lacinia quis egestas purus aliquet. Vivamus non est tortor, vitae pulvinar eros. Nullam non dapibus lectus. Quisque rhoncus iaculis turpis, eget lacinia dui porta et. Donec et tellus eu risus hendrerit posuere. Ut adipiscing enim at augue egestas at lacinia arcu blandit. Aenean vitae justo in lectus vestibulum mattis id vel risus. Aliquam viverra, lorem at tincidunt pretium, nulla turpis vulputate lorem, vel interdum ipsum felis id sem. Nullam et neque nulla. Aliquam id mi at tortor congue elementum. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Sed bibendum scelerisque pretium. Nullam sed sem nibh, sit amet sodales tellus. Suspendisse consequat viverra enim sit amet convallis. Etiam nulla orci, elementum a congue vel, aliquam at nisi. Praesent ac erat eleifend lectus pellentesque suscipit vitae quis nunc. Fusce fermentum condimentum enim quis consequat. Aliquam mattis sapien at magna congue molestie.</div><div><br></div><div><b>Aenean egestas egestas mauris, et viverra arcu luctus fringilla. Maecenas nec turpis ac dui lacinia mollis et non dolor. Aliquam scelerisque pharetra est eget aliquet. Maecenas cursus tellus ut tellus euismod accumsan eget quis odio. In hac habitasse platea dictumst. Donec dictum elit eget augue varius nec imperdiet erat vulputate. Ut vel ligula ac erat lacinia euismod. Praesent mauris lectus, congue nec sodales ac, convallis non justo. Fusce varius convallis metus, quis vestibulum ligula commodo vel. Nullam interdum auctor interdum. Aenean justo quam, aliquam sed ultrices sed, aliquet quis tellus. In id ligula lacus. Morbi vel lacus sed odio vulputate molestie. Cras odio ipsum, pretium vel pharetra sed, fermentum lacinia justo. Mauris vestibulum metus ac metus sagittis tempus.</b></div><div><br></div><div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut gravida convallis orci, nec semper neque tempor vel. Suspendisse aliquet convallis velit, et vulputate odio consectetur bibendum. Aenean ultrices, turpis quis vehicula vehicula, velit augue dignissim nisl, ut dignissim elit lorem quis leo. Suspendisse congue mauris id massa auctor sed convallis leo adipiscing. Phasellus commodo pellentesque facilisis. Sed consectetur, quam sit amet sagittis ullamcorper, leo lectus fringilla justo, vel condimentum nisl purus eget tellus. Nunc sed odio ac nisi tempus molestie. In congue orci sed augue blandit vulputate. Mauris rutrum felis sed tortor suscipit eleifend. Vestibulum et magna molestie neque consectetur venenatis in ac odio. Donec lacus lorem, semper vel pretium vitae, interdum nec lacus. Vivamus pretium turpis ut dolor porta condimentum. Aenean non ipsum odio. Vestibulum pharetra blandit justo, in semper orci fringilla vitae. Nulla malesuada nulla id sem lobortis suscipit. Vestibulum et nulla orci. Duis posuere commodo magna, sed vehicula dui convallis quis.</div>');

/*!40000 ALTER TABLE `nodes` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
