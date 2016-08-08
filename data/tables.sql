-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema prezi_finder
-- -----------------------------------------------------
DROP SCHEMA IF EXISTS `prezi_finder` ;

-- -----------------------------------------------------
-- Schema prezi_finder
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `prezi_finder` DEFAULT CHARACTER SET latin1 ;
USE `prezi_finder` ;

-- -----------------------------------------------------
-- Table `prezi_finder`.`prezis`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `prezi_finder`.`prezis` ;

CREATE TABLE IF NOT EXISTS `prezi_finder`.`prezis` (
  `id` VARCHAR(255) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `thumbnail` VARCHAR(255) NOT NULL,
  `createdAt` DATETIME NOT NULL,
  `creator_id` INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `prezi_finder`.`creators`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `prezi_finder`.`creators` ;

CREATE TABLE IF NOT EXISTS `prezi_finder`.`creators` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `profileUrl` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
