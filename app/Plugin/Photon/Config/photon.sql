

-- -----------------------------------------------------
-- Table `mydb`.`albums`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `albums` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `weight` INT NULL ,
  `title` VARCHAR(45) NOT NULL ,
  `slug` VARCHAR(45) NOT NULL ,
  `description` TEXT NULL ,
  `status` TINYINT(1)  NOT NULL ,
  `node_id` INT NULL,
   `link_id` INT NULL,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`photos`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `photos` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `weight` INT NULL ,
  `album_id` INT NOT NULL ,
  `title` VARCHAR(45) NULL ,
  `description` TEXT NULL ,
  `small` VARCHAR(255) NULL ,
  `large` VARCHAR(255) NULL ,
   `term1` VARCHAR(255) NULL ,
   `term2` VARCHAR(255) NULL ,
   `term3` VARCHAR(255) NULL ,
   `term4` VARCHAR(255) NULL ,
   `term5` VARCHAR(255) NULL ,
    `item_code` VARCHAR(255) NULL ,
     `price` DECIMAL(10,2) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_photos_albums` (`album_id` ASC) ,
  CONSTRAINT `fk_photos_albums`
    FOREIGN KEY (`album_id` )
    REFERENCES `albums` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

