CREATE DATABASE `baseeteste` /*!40100 DEFAULT CHARACTER SET latin1 */;
CREATE TABLE `tbusuario` (
  `id_usuario` bigint(20) NOT NULL AUTO_INCREMENT,
  `tx_nome` varchar(45) NOT NULL,
  `tx_email` varchar(45) DEFAULT NULL,
  `tx_telefone` varchar(45) DEFAULT NULL,
  `tx_celular` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id_usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

