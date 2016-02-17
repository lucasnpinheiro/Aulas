-- MySQL dump 10.13  Distrib 5.7.9, for linux-glibc2.5 (x86_64)
--
-- Host: localhost    Database: tosabeta
-- ------------------------------------------------------
-- Server version	5.5.5-10.0.21-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `administradores`
--

LOCK TABLES `administradores` WRITE;
/*!40000 ALTER TABLE `administradores` DISABLE KEYS */;
INSERT  IGNORE INTO `administradores` (`id`, `nome`, `email`, `senha`, `status`, `created`, `modified`) VALUES (1,'Administrador','diretoria@williarts.com.br','e10adc3949ba59abbe56e057f20f883e',1,NULL,NULL);
/*!40000 ALTER TABLE `administradores` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `animais_tipos`
--

LOCK TABLES `animais_tipos` WRITE;
/*!40000 ALTER TABLE `animais_tipos` DISABLE KEYS */;
INSERT  IGNORE INTO `animais_tipos` (`id`, `nome`, `created`, `modified`) VALUES (1,'Cachorro',NULL,NULL),(2,'Gato',NULL,NULL),(3,'Outros',NULL,NULL);
/*!40000 ALTER TABLE `animais_tipos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `menus`
--

LOCK TABLES `menus` WRITE;
/*!40000 ALTER TABLE `menus` DISABLE KEYS */;
INSERT  IGNORE INTO `menus` (`id`, `titulo`, `path`, `controller`, `action`, `tosador`, `administrador`, `ordem`, `id_pai`, `item_menu`, `icone`, `created`, `modified`) VALUES (1,'Consultar','painel','animais','index',0,1,0,0,0,NULL,'2016-02-05 08:48:22',NULL),(2,'Cadastrar','painel','animais','add',0,1,0,0,0,NULL,'2016-02-05 08:48:22',NULL),(3,'Alterar','painel','animais','edit',0,1,0,0,0,NULL,'2016-02-05 08:48:22',NULL),(4,'Excluir','painel','animais','delete',0,1,0,0,0,NULL,'2016-02-05 08:48:22',NULL),(5,'Consultar','painel','animais_tipos','index',0,1,0,0,0,NULL,'2016-02-05 08:48:42',NULL),(6,'Cadastrar','painel','animais_tipos','add',0,1,0,0,0,NULL,'2016-02-05 08:48:42',NULL),(7,'Alterar','painel','animais_tipos','edit',0,1,0,0,0,NULL,'2016-02-05 08:48:42',NULL),(8,'Excluir','painel','animais_tipos','delete',0,1,0,0,0,NULL,'2016-02-05 08:48:42',NULL),(9,'Banho e Tosa','painel','banhos_tosas','index',0,1,2,0,1,'<i class=\"fa fa-tint\"></i>','2016-02-05 08:48:54',NULL),(10,'Cadastrar','painel','banhos_tosas','add',0,1,0,0,0,NULL,'2016-02-05 08:48:54',NULL),(11,'Alterar','painel','banhos_tosas','edit',0,1,0,0,0,NULL,'2016-02-05 08:48:54',NULL),(12,'Excluir','painel','banhos_tosas','delete',0,1,0,0,0,NULL,'2016-02-05 08:48:54',NULL),(13,'Clientes','painel','clientes','index',0,1,0,0,1,'<i class=\"fa fa-user-plus\"></i>','2016-02-05 08:49:03',NULL),(14,'Cadastrar','painel','clientes','add',0,1,0,0,0,NULL,'2016-02-05 08:49:03',NULL),(15,'Alterar','painel','clientes','edit',0,1,0,0,0,NULL,'2016-02-05 08:49:03',NULL),(16,'Excluir','painel','clientes','delete',0,1,0,0,0,NULL,'2016-02-05 08:49:03',NULL),(17,'Consultar','painel','comissao','index',0,1,0,0,0,NULL,'2016-02-05 08:49:14',NULL),(18,'Cadastrar','painel','comissao','add',0,1,0,0,0,NULL,'2016-02-05 08:49:14',NULL),(19,'Alterar','painel','comissao','edit',0,1,0,0,0,NULL,'2016-02-05 08:49:14',NULL),(20,'Excluir','painel','comissao','delete',0,1,0,0,0,NULL,'2016-02-05 08:49:15',NULL),(21,'Consultar','painel','empresas','index',0,1,0,0,0,NULL,'2016-02-05 08:49:24',NULL),(22,'Cadastrar','painel','empresas','add',0,1,0,0,0,NULL,'2016-02-05 08:49:24',NULL),(23,'Alterar','painel','empresas','edit',0,1,0,0,0,NULL,'2016-02-05 08:49:24',NULL),(24,'Excluir','painel','empresas','delete',0,1,0,0,0,NULL,'2016-02-05 08:49:24',NULL),(25,'Consultar','painel','empresas_usuarios','index',0,1,0,0,0,NULL,'2016-02-05 08:49:36',NULL),(26,'Cadastrar','painel','empresas_usuarios','add',0,1,0,0,0,NULL,'2016-02-05 08:49:36',NULL),(27,'Alterar','painel','empresas_usuarios','edit',1,1,0,0,0,NULL,'2016-02-05 08:49:36',NULL),(28,'Excluir','painel','empresas_usuarios','delete',0,1,0,0,0,NULL,'2016-02-05 08:49:36',NULL),(29,'Veterinário','painel','veterinarios','index',0,1,4,0,1,'<i class=\"fa fa-medkit\"></i>','2016-02-05 08:51:20',NULL),(30,'Cadastrar','painel','veterinarios','add',0,1,0,0,0,NULL,'2016-02-05 08:51:20',NULL),(31,'Alterar','painel','veterinarios','edit',0,1,0,0,0,NULL,'2016-02-05 08:51:20',NULL),(32,'Excluir','painel','veterinarios','delete',0,1,0,0,0,NULL,'2016-02-05 08:51:20',NULL),(33,'Tosador','painel','empresas_usuarios','tosador',1,1,3,0,1,'<i class=\"fa fa-scissors\"></i>','2016-02-05 08:49:36',NULL),(34,'Configurações','painel','empresas_usuarios','configuracoes',1,1,7,0,1,'<i class=\"fa fa-cogs\"></i>','2016-02-05 08:49:36',NULL),(35,'PETs','painel','animais','animais',0,1,1,0,1,'<i class=\"fa fa-paw\"></i>','2016-02-05 08:48:22',NULL),(36,'Financeiro','painel','empresas_usuarios','financeiro',0,1,6,0,1,'<i class=\"fa fa-usd\"></i>','2016-02-05 08:49:36',NULL),(37,'Clientes','painel','animais','clientes',0,1,0,0,0,NULL,'2016-02-05 08:48:22',NULL),(38,'Concluir','painel','banhos_tosas','concluir',1,1,0,0,0,NULL,'2016-02-05 08:48:54',NULL),(39,'Lista Animais','painel','banhos_tosas','list_animais',0,1,0,0,0,NULL,'2016-02-05 08:48:54',NULL),(40,'Lista Clientes','painel','banhos_tosas','list_clientes',0,1,0,0,0,NULL,'2016-02-05 08:48:54',NULL),(41,'Tosador','painel','banhos_tosas','tosador',0,1,0,0,0,NULL,'2016-02-05 08:48:54',NULL),(42,'Financeiro','painel','empresas','financeiro',0,1,0,0,0,NULL,'2016-02-05 08:49:24',NULL),(43,'Alterar Usuário','painel','empresas_usuarios','edit_usuario',0,1,0,0,0,NULL,'2016-02-05 08:49:36',NULL),(44,'Animais','painel','veterinarios','animais',0,1,0,0,0,NULL,'2016-02-05 08:51:20',NULL),(45,'Clientes','painel','veterinarios','clientes',0,1,0,0,0,NULL,'2016-02-05 08:51:20',NULL),(46,'Notificações','painel','veterinarios','lembretes',0,1,5,0,1,'<i class=\"fa fa-bell-o\"></i>','2016-02-05 08:51:20',NULL),(47,'Editar Notificações','painel','veterinarios','edit_lembrete',1,1,0,0,0,NULL,'2016-02-05 08:51:20',NULL);
/*!40000 ALTER TABLE `menus` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `parametros`
--

LOCK TABLES `parametros` WRITE;
/*!40000 ALTER TABLE `parametros` DISABLE KEYS */;
INSERT  IGNORE INTO `parametros` (`id`, `nome`, `chave`, `valor`, `tipo`, `options`, `required`, `grupo`, `sub_grupo`) VALUES (1,'Versão','Versao','1','string',NULL,0,'Geral',NULL),(2,'Titulo','Titulo','Appettosa','text',NULL,1,'Geral',NULL),(3,'Host','Host','smtp.appettosa.com.br','text',NULL,1,'Email','default'),(5,'Autenticação','Auth','1','select','[\"N\\u00e3o\",\"Sim\"]',1,'Email','default'),(6,'Nome','Name','Appettosa','text',NULL,1,'Email','default'),(7,'Usuário','Username','suporte@appettosa.com.br','text',NULL,1,'Email','default'),(8,'Senha','Password','willian321','password',NULL,1,'Email','default'),(9,'Tipo segurança','Secure','','text',NULL,0,'Email','default'),(10,'Porta','Port','587','text',NULL,1,'Email','default'),(11,'Debugar','Debug','0','select','[\"N\\u00e3o\",\"Sim\"]',1,'Email','default'),(12,'Charset','Charset','utf-8','text',NULL,1,'Email','default'),(13,'Token','Token','YV5YFBXHFOEDZNWKXCPDFVGYNJ2OKVB0','text',NULL,1,'Moip',NULL),(14,'Chave','Chave','81QUTDRIZCEJ56DHSOCQHU41MOGEWVM4BWSQ4JTN','text',NULL,1,'Moip',NULL),(15,'Auto TLS','AutoTls','0','select','[\"N\\u00e3o\",\"Sim\"]',1,'Email','default'),(16,'Chave Live','Live.Padrao','ak_live_zt1svzcARdBRIz5gdE1BS7Ci74mCup','text',NULL,1,'PagarMe',NULL),(17,'Chave Live Criptografada','Live.Criptografada','ek_live_aWt8RC5B2Fu9EYguQYoAuZr60eucRS','text',NULL,1,'PagarMe',NULL),(18,'Chave Test','Test.Padrao','ak_test_sAhswl8QV2KDPtTFOipVkqJ6KsPqPA','text',NULL,1,'PagarMe',NULL),(19,'Chave Test Criptografada','Test.Criptografada','ek_test_dVqHW57YXUwX5JDtTY9VE7z1zCHUT8','text',NULL,1,'PagarMe',NULL),(20,'Ambiente','Ambiente','0','select','[\"Teste\",\"Produção\"]',1,'PagarMe',NULL),(21,'Tempo de Expiração do Usuário Trial','Tempo.Expiracao','7','number',NULL,1,'Geral',NULL);
/*!40000 ALTER TABLE `parametros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `planos`
--

LOCK TABLES `planos` WRITE;
/*!40000 ALTER TABLE `planos` DISABLE KEYS */;
INSERT  IGNORE INTO `planos` (`id`, `nome`, `valor`, `periodo`, `status`, `created`, `modified`) VALUES (1,'Gratis',0.00,12,1,'2016-02-03 17:26:08',NULL),(2,'Gratis teste s',0.00,12,9,'2016-02-10 16:17:40','2016-02-10 16:20:06');
/*!40000 ALTER TABLE `planos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-02-17 15:53:02
