
-- --------------------------------------------------------

--
-- Table structure for table `dg_article`
--

CREATE TABLE IF NOT EXISTS `dg_article` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `cate_id` int(11) NOT NULL,
  `meta_title` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `meta_description` text NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `publish` varchar(1) NOT NULL DEFAULT '1',
  `date` datetime NOT NULL,
  `created` varchar(100) NOT NULL,
  `view` int(10) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_attributes`
--

CREATE TABLE IF NOT EXISTS `dg_attributes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `titles` text NOT NULL,
  `prices` text NOT NULL,
  `product_id` int(11) NOT NULL,
  `type` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_banner`
--

CREATE TABLE IF NOT EXISTS `dg_banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(32) NOT NULL,
  `title` varchar(200) NOT NULL,
  `images` text NOT NULL,
  `captions` text NOT NULL,
  `settings` text NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_categories`
--

CREATE TABLE IF NOT EXISTS `dg_categories` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(20) NOT NULL COMMENT 'clipart, font',
  `title` varchar(200) NOT NULL,
  `layout` int(11) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `level` int(3) NOT NULL DEFAULT '1',
  `description` text NOT NULL,
  `image` text NOT NULL,
  `parent_id` int(10) NOT NULL,
  `published` varchar(1) NOT NULL,
  `language` varchar(5) NOT NULL,
  `meta_title` text NOT NULL,
  `meta_keyword` text NOT NULL,
  `meta_description` text NOT NULL,
  `created` datetime NOT NULL,
  `order` int(4) NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_cliparts`
--

CREATE TABLE IF NOT EXISTS `dg_cliparts` (
  `clipart_id` int(100) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `system_id` int(11) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `cate_id` int(11) NOT NULL,
  `add_price` varchar(1) NOT NULL DEFAULT '0',
  `status` varchar(2) NOT NULL DEFAULT '1' COMMENT '1. display, 0. pending, -1. deny',
  `feature` int(1) NOT NULL DEFAULT '0',
  `copyright` int(1) NOT NULL DEFAULT '0',
  `type` varchar(20) NOT NULL COMMENT 'photo, icon, vertor',
  `fle_url` text NOT NULL,
  `file_name` varchar(200) NOT NULL,
  `file_type` varchar(200) NOT NULL,
  `colors` text NOT NULL,
  `change_color` int(1) NOT NULL DEFAULT '0',
  `view` int(100) NOT NULL,
  `system` tinyint(1) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `remove` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`clipart_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_colors`
--

CREATE TABLE IF NOT EXISTS `dg_colors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hex` varchar(7) NOT NULL,
  `title` varchar(250) NOT NULL,
  `type` varchar(100) NOT NULL,
  `lang_code` varchar(5) NOT NULL,
  `published` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_config_emails`
--

CREATE TABLE IF NOT EXISTS `dg_config_emails` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `label` varchar(255) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_contact`
--

CREATE TABLE IF NOT EXISTS `dg_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `key` varchar(32) NOT NULL,
  `subject` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `copy` varchar(1) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_country`
--

CREATE TABLE IF NOT EXISTS `dg_country` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `code_2` varchar(2) NOT NULL,
  `code_3` varchar(3) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_coupon`
--

CREATE TABLE IF NOT EXISTS `dg_coupon` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `code` varchar(32) NOT NULL,
  `value` float NOT NULL,
  `discount_type` varchar(1) NOT NULL DEFAULT 't' COMMENT 't: total, p: Percent',
  `coupon_type` varchar(1) NOT NULL DEFAULT 'p' COMMENT 'p: Permanent Coupon, g: Gift Coupon',
  `minimum` float NOT NULL,
  `publish` varchar(1) NOT NULL DEFAULT '1',
  `count` int(5) NOT NULL DEFAULT '0',
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_currencies`
--

CREATE TABLE IF NOT EXISTS `dg_currencies` (
  `currency_id` int(10) NOT NULL AUTO_INCREMENT,
  `currency_name` varchar(200) NOT NULL,
  `currency_code` varchar(3) NOT NULL,
  `currency_symbol` varchar(10) NOT NULL,
  `published` varchar(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`currency_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_custom_fields`
--

CREATE TABLE IF NOT EXISTS `dg_custom_fields` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(200) NOT NULL,
  `title` varchar(200) NOT NULL,
  `type` varchar(50) NOT NULL,
  `validate` varchar(1) NOT NULL DEFAULT '0',
  `publish` varchar(1) NOT NULL,
  `edit` varchar(1) NOT NULL DEFAULT '1',
  `value` text NOT NULL,
  `forms` text NOT NULL,
  `order` int(10) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_design_idea`
--

CREATE TABLE IF NOT EXISTS `dg_design_idea` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` text NOT NULL,
  `design_id` int(11) NOT NULL,
  `cate_id` int(11) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `meta_title` varchar(255) NOT NULL,
  `meta_keywords` text NOT NULL,
  `meta_description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_fields_value`
--

CREATE TABLE IF NOT EXISTS `dg_fields_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `field_id` int(11) NOT NULL,
  `form_field` varchar(200) NOT NULL,
  `value` text NOT NULL,
  `object` varchar(200) NOT NULL COMMENT 'user_id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_fonts`
--

CREATE TABLE IF NOT EXISTS `dg_fonts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'google',
  `subtitle` varchar(200) NOT NULL,
  `filename` varchar(200) NOT NULL,
  `path` varchar(250) NOT NULL,
  `thumb` varchar(255) NOT NULL,
  `cate_id` int(11) NOT NULL,
  `published` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_layout`
--

CREATE TABLE IF NOT EXISTS `dg_layout` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `layout` varchar(255) NOT NULL,
  `html` text NOT NULL,
  `content` text NOT NULL,
  `description` text NOT NULL,
  `published` int(1) NOT NULL DEFAULT '1',
  `default` int(1) NOT NULL DEFAULT '0',
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_menus`
--

CREATE TABLE IF NOT EXISTS `dg_menus` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `attribute` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `subitem` text NOT NULL,
  `html` text NOT NULL,
  `options` text NOT NULL,
  `published` int(1) NOT NULL DEFAULT '1',
  `menu_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_menu_type`
--

CREATE TABLE IF NOT EXISTS `dg_menu_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_modules`
--

CREATE TABLE IF NOT EXISTS `dg_modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `type` varchar(100) NOT NULL,
  `key` varchar(32) NOT NULL,
  `content` text NOT NULL,
  `options` text NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_orders`
--

CREATE TABLE IF NOT EXISTS `dg_orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_number` varchar(10) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_pass` varchar(10) NOT NULL COMMENT 'Help client check order',
  `payment_id` int(11) NOT NULL,
  `payment_price` float NOT NULL DEFAULT '0',
  `shipping_id` int(11) NOT NULL,
  `shipping_price` float NOT NULL DEFAULT '0',
  `sub_total` float NOT NULL DEFAULT '0',
  `total` float NOT NULL DEFAULT '0',
  `discount_id` int(11) NOT NULL DEFAULT '0',
  `discount` float NOT NULL DEFAULT '0',
  `tax` float NOT NULL,
  `status` varchar(200) NOT NULL,
  `created_on` datetime NOT NULL,
  `modified_on` datetime NOT NULL,
  `client_note` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Used to store all orders' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_orders_histories`
--

CREATE TABLE IF NOT EXISTS `dg_orders_histories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `label` varchar(200) NOT NULL,
  `content` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='store change of each order' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_orders_userinfo`
--

CREATE TABLE IF NOT EXISTS `dg_orders_userinfo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address` text NOT NULL COMMENT 'save with json',
  `created_on` datetime NOT NULL,
  `modified_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_order_cliparts`
--

CREATE TABLE IF NOT EXISTS `dg_order_cliparts` (
  `id` int(100) NOT NULL AUTO_INCREMENT,
  `clipart_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending',
  `created` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_order_items`
--

CREATE TABLE IF NOT EXISTS `dg_order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `design_id` varchar(20) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_sku` varchar(200) NOT NULL,
  `product_price` float NOT NULL,
  `price_print` float NOT NULL,
  `price_clipart` float NOT NULL,
  `price_attributes` float NOT NULL,
  `quantity` int(5) NOT NULL,
  `poduct_status` varchar(200) NOT NULL,
  `attributes` text NOT NULL,
  `created_on` datetime NOT NULL,
  `modified_on` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Stores all items (products) which are part of an order' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_pages`
--

CREATE TABLE IF NOT EXISTS `dg_pages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `html` text NOT NULL,
  `content` text NOT NULL,
  `meta_title` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `meta_description` text NOT NULL,
  `published` int(1) NOT NULL DEFAULT '1',
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_payments`
--

CREATE TABLE IF NOT EXISTS `dg_payments` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `type` varchar(50) NOT NULL,
  `default` varchar(1) NOT NULL DEFAULT '0',
  `published` varchar(1) NOT NULL DEFAULT '1',
  `configs` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_products`
--

CREATE TABLE IF NOT EXISTS `dg_products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(250) NOT NULL,
  `slug` varchar(250) NOT NULL,
  `description` text NOT NULL,
  `short_description` text NOT NULL,
  `size` text NOT NULL,
  `sku` varchar(200) NOT NULL,
  `layout` int(5) NOT NULL,
  `print_type` varchar(200) NOT NULL,
  `price` float NOT NULL,
  `sale_price` float NOT NULL,
  `image` text NOT NULL,
  `gallery` text NOT NULL,
  `min_order` int(2) NOT NULL,
  `max_oder` int(5) NOT NULL,
  `default` int(1) DEFAULT '0',
  `future` varchar(1) NOT NULL DEFAULT '0',
  `published` int(1) NOT NULL,
  `created` datetime NOT NULL,
  `ordering` int(5) NOT NULL,
  `currency_id` int(11) NOT NULL,
  `params` text NOT NULL,
  `meta_title` text NOT NULL,
  `meta_keywords` text NOT NULL,
  `meta_description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_products_design`
--

CREATE TABLE IF NOT EXISTS `dg_products_design` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `color_hex` text NOT NULL,
  `color_title` text NOT NULL,
  `price` text NOT NULL,
  `default` text NOT NULL,
  `front` text NOT NULL,
  `back` text NOT NULL,
  `left` text NOT NULL,
  `right` text NOT NULL,
  `area` text NOT NULL,
  `status` int(11) NOT NULL,
  `params` text NOT NULL,
  `ordering` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_product_categories`
--

CREATE TABLE IF NOT EXISTS `dg_product_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `cate_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_product_prices`
--

CREATE TABLE IF NOT EXISTS `dg_product_prices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `product_id` int(11) NOT NULL,
  `min_quantity` varchar(250) NOT NULL,
  `max_quantity` varchar(250) NOT NULL,
  `price` varchar(250) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_sessions`
--

CREATE TABLE IF NOT EXISTS `dg_sessions` (
  `session_id` varchar(32) NOT NULL,
  `user_agent` varchar(255) NOT NULL,
  `ip_address` varchar(20) NOT NULL,
  `last_activity` int(12) NOT NULL,
  `user_data` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `dg_settings`
--

CREATE TABLE IF NOT EXISTS `dg_settings` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `settings` text NOT NULL,
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_shippings`
--

CREATE TABLE IF NOT EXISTS `dg_shippings` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `default` varchar(1) NOT NULL DEFAULT '0',
  `price` float NOT NULL,
  `published` varchar(1) NOT NULL DEFAULT '1',
  `date` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_states`
--

CREATE TABLE IF NOT EXISTS `dg_states` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `country_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `code` varchar(32) NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_users`
--

CREATE TABLE IF NOT EXISTS `dg_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(150) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(128) NOT NULL,
  `block` tinyint(4) NOT NULL DEFAULT '0',
  `group` varchar(1) NOT NULL DEFAULT '1',
  `send_email` tinyint(4) DEFAULT '0',
  `register_date` datetime NOT NULL,
  `lastvisitdate` datetime NOT NULL,
  `activation` varchar(100) NOT NULL,
  `params` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_users_designs`
--

CREATE TABLE IF NOT EXISTS `dg_users_designs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `design_id` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `system_id` int(11) NOT NULL DEFAULT '0',
  `product_id` int(11) NOT NULL,
  `product_options` text NOT NULL,
  `vectors` longtext NOT NULL,
  `fonts` text NOT NULL,
  `teams` text NOT NULL,
  `image` text NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_users_temp`
--

CREATE TABLE IF NOT EXISTS `dg_users_temp` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(250) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL,
  `key` varchar(200) NOT NULL,
  `created` datetime NOT NULL,
  `params` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `dg_user_groups`
--

CREATE TABLE IF NOT EXISTS `dg_user_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `default` varchar(1) NOT NULL DEFAULT '0',
  `permissions` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;