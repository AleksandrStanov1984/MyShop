<?php

class ModelExtensionFeedNeoSeoProductFeedFormats extends Model
{

	// Install/Uninstall
	public function install()
	{

		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "product_feed_format` ( 
            `product_feed_format_id` int(11) NOT NULL AUTO_INCREMENT,  
            `feed_format_name` varchar(128) NOT NULL, 
            `format_xml` text NOT NULL,
            PRIMARY KEY (`product_feed_format_id`) 
        )  CHARACTER SET utf8 COLLATE utf8_general_ci;");

		$yml = '<?xml version="1.0" encoding="UTF-8"?>
<yml_catalog date="{{date}}">
  <shop>
    <name>Мой магазин</name>
    <company>Большая компания</company>
    <url>{{url}}</url>
    <currencies>
      <currency id="{{currency}}" rate="1"/>
    </currencies>
    <categories>
{% for category in categories%}
      <category id="{{category.id}}" {% if category.parentId  %} parentId="{{category.parentId}}" {% endif %}>{{category.name}}</category>
{% endfor %}
    </categories>
    <offers>
{% for offer in offers%}
      <offer available="true" id="{{offer.id}}">
        <url>{{offer.url}} </url>
        <price>{{offer.price}}</price>
        {% if offer.oldprice %}<oldprice>{{offer.oldprice}}</oldprice>{% endif %}
        <currencyId>{{offer.currencyId}}</currencyId>
        <categoryId>{{offer.categoryId}}</categoryId>
        <name>{{offer.name}}</name>
        <description>{{offer.description}}</description>
        <model>{{offer.model}}</model>
        <vendor>{{offer.vendor}}</vendor>
        <vendorCode>{{offer.vendorCode}}</vendorCode>
        <pickup>false</pickup>
        <delivery>false</delivery>
        <store>false</store>
{% for image in offer.image %}
        <picture>{{image}}</picture>
{% endfor %}
{% for attribute in offer.attributes %}
        <param name="{{attribute.name}}">{{attribute.value}}</param>
{% endfor %}
      </offer>
{% endfor %}
    </offers>
  </shop>
</yml_catalog>';

		$yml2 = '<?xml version="1.0" encoding="UTF-8"?>
<yml_catalog date="{{date}}">
  <shop>
    <name>Мой магазин</name>
    <company>Большая компания</company>
    <url>{{url}}</url>
    <currencies>
      <currency id="{{currency}}" rate="1"/>
    </currencies>
    <categories>
{% for category in categories%}
      <category id="{{category.id}}" {% if category.parentId  %} parentId="{{category.parentId}}" {% endif %}>{{category.name}}</category>
{% endfor %}
    </categories>
    <offers>
{% for offer in offers%}
{% if offer.options %}
{% for option in offer.options %}
{% if option.name == "Size" and option.quantity > 0 %}
      <offer available="true" id="{{offer.id}}-{{option.id}}">
{% for attribute in offer.attributes %}
{% if attribute.name == "group_id" %}
        <group_id>{{attribute.value}}</group_id>
{% endif %}
{% endfor %}
        <url>{{offer.url}} </url>
        <price>{{option.price}}</price>
        {% if offer.oldprice %}<oldprice>{{offer.oldprice}}</oldprice>{% endif %}
        <currencyId>{{offer.currencyId}}</currencyId>
        <categoryId>{{offer.categoryId}}</categoryId>
        <name>{{offer.name}}</name>
        <description>{{offer.description}}</description>
        <model>{{offer.model}}</model>
        <vendor>{{offer.vendor}}</vendor>
        <vendorCode>{{offer.vendorCode}}</vendorCode>
        <pickup>false</pickup>
        <delivery>false</delivery>
        <store>false</store>
{% for image in offer.image %}
        <picture>{{image}}</picture>
{% endfor %}
{% for attribute in offer.attributes %}
{% if attribute.name == "group_id" %}
{% else %}
        <param name="{{attribute.name}}">{{attribute.value}}</param>
{% endif %}
{% endfor %}
        <param name="Размер" unit="eu">{{option.value}}</param>
      </offer>
{% endif %}
{% endfor %}
{% else %}
      <offer available="true" id="{{offer.id}}">
        <url>{{offer.url}} </url>
        <price>{{offer.price}}</price>
        {% if offer.oldprice %}<oldprice>{{offer.oldprice}}</oldprice>{% endif %}
        <currencyId>{{offer.currencyId}}</currencyId>
        <categoryId>{{offer.categoryId}}</categoryId>
        <name>{{offer.name}}</name>
        <description>{{offer.description}}</description>
        <model>{{offer.model}}</model>
        <vendor>{{offer.vendor}}</vendor>
        <vendorCode>{{offer.vendorCode}}</vendorCode>
        <pickup>false</pickup>
        <delivery>false</delivery>
        <store>false</store>
{% for image in offer.image %}
        <picture>{{image}}</picture>
{% endfor %}
{% for attribute in offer.attributes %}
        <param name="{{attribute.name}}">{{attribute.value}}</param>
{% endfor %}
      </offer>
{% endif %}
{% endfor %}
    </offers>
  </shop>
</yml_catalog>
';

		$hotline = '<?xml version="1.0" encoding="UTF-8"?>
<price>
  <date>{{date}}</date>
  <firmName>Мой магазин</firmName>
  <firmId>Идентификатор магазина</firmId>
  <categories>
{% for category in categories%}
    <category>
      <id>{{category.id}}</id>
{% if category.parentId  %}
      <parentId>{{category.parentId}}</parentId>
{% endif %}
      <name>{{category.name}}</name>
    </category>
{% endfor %}
  </categories>
  <items>
{% for offer in offers%}
    <item>
      <id>{{offer.id}}</id>
      <url>{{offer.url}}</url>
      <priceRUAH>{{offer.price}}</priceRUAH>
      <stock>В наличии</stock>
      <guarantee>12 месяцев, от производителя</guarantee>
      {% if offer.oldprice %}<oldprice>{{offer.oldprice}}</oldprice>{% endif %}
      <categoryId>{{offer.categoryId}}</categoryId>
      <code>{{offer.code}}</code>
      <name>{{offer.name}}</name>
      <description>{{offer.description}}</description>
      <vendor>{{offer.vendor}}</vendor>
{% for image in offer.image %}
      <image>{{image}}</image>
{% endfor %}
{% for attribute in offer.attributes %}
      <param name="{{attribute.name}}">{{attribute.value}}</param>
{% endfor %}
    </item>
{% endfor %}
  </items>
</price>';

		$prom_ua = '<?xml version="1.0" encoding="UTF-8"?>
<price date="{{date}}">
  <name>Мой магазин</name>
  <company>Моя компания</company>
  <url>{{url}}</url>
  <currency code="{{currency}}" rate="1"/>
  <categories>
{% for category in categories%}
    <category id="{{category.id}}" {% if category.parentId  %} parentId="{{category.parentId}}" {% endif %}>{{category.name}}</category>
{% endfor %}
  </categories>
  <items>
{% for offer in offers%}
    <item id="{{offer.id}}" available="true">
      <url>{{offer.url}}</url>
      <price>{{offer.price}}</price>
      {% if offer.oldprice %}<oldprice>{{offer.oldprice}}</oldprice>{% endif %}
      <categoryId>{{offer.categoryId}}</categoryId>
      <name>{{offer.name}}</name>
      <description>{{offer.description}}</description>
      <model>{{offer.model}}</model>
      <vendor>{{offer.vendor}}</vendor>
      <vendorCode>{{offer.vendorCode}}</vendorCode>
{% for image in offer.image %}
      <image>{{image}}</image>
{% endfor %}
{% for attribute in offer.attributes %}
      <param name="{{attribute.name}}">{{attribute.value}}</param>
{% endfor %}
    </item>
{% endfor %}
  </items>
</price>';

		$google_merchant = '<?xml version="1.0" encoding="UTF-8"?>
<rss xmlns:g="http://base.google.com/ns/1.0" version="2.0">
<channel>
  <title>Мой магазин</title>
  <link>{{url}}</link>
  <description>Описание моего магазина</description>
{% for offer in offers%}
  <item>
    <g:id>{{offer.id}}</g:id>
    <g:title>{{offer.name}}</g:title>
    <g:description>{{offer.description}}</g:description>    
    <g:link>{{offer.url}}</g:link>
    <g:mobile_link>{{offer.url}}</g:mobile_link>
    <g:image_link>{{offer.image[0]}}</g:image_link>
{% for image in offer.image %}
{% if loop.index != 1  %}
    <g:additional_image_link>{{image}}</g:additional_image_link>
{% endif %}
{% endfor %}
    <g:condition>new</g:condition>
    <g:availability>{% if offer.quantity > 0 %}in stock{% else %}out of stock{% endif %}</g:availability>
    <g:price>{{offer.price}} {{currency}}</g:price>
    <g:brand>{{offer.model}}</g:brand>
  </item>
{% endfor %}
</channel>
</rss>';

		$facebook = '<?xml version="1.0"?>
<feed xmlns="https://www.w3.org/2005/Atom" xmlns:g="https://base.google.com/ns/1.0">
	<title>Мой магазин</title>
	<link rel="self" href="{{url}}"/>
	<g:description>Описание магазина</g:description>
{% for offer in offers%}
	<entry>
		<g:id>{{offer.id}}</g:id>
		<g:title>{{offer.name}}</g:title>
		<g:description><![CDATA[{{offer.description}}]]></g:description>
		<g:link>{{offer.url}}</g:link>
		{% for image in offer.image %}
			<g:image_link>{{image}}</g:image_link>
		{% endfor %}
		<g:brand>{{offer.vendor}}</g:brand>
		<g:condition>new</g:condition>
		<g:availability>{% if offer.quantity > 0 %}in stock{% else %}out of stock{% endif %}</g:availability>
		{% if offer.oldprice %}
			<g:price>{{offer.oldprice}}</g:price>
		{% else %} 
			<g:price>{{offer.price}}</g:price>
		{% endif %}
		<g:shipping_weight>{{offer.weight}} g</g:shipping_weight>
		<g:shipping>
		<g:country>UA</g:country>
		<g:service>Доставка</g:service>
		</g:shipping> 
	</entry>
{% endfor %}
</feed>';

		$sql = array();
		$sql[] = "INSERT INTO `" . DB_PREFIX . "product_feed_format` (`feed_format_name`, `format_xml`) VALUES ('YML','" . htmlspecialchars($yml) . "');";
		$sql[] = "INSERT INTO `" . DB_PREFIX . "product_feed_format` (`feed_format_name`, `format_xml`) VALUES ('HOTLINE.UA','" . htmlspecialchars($hotline) . "');";
		$sql[] = "INSERT INTO `" . DB_PREFIX . "product_feed_format` (`feed_format_name`, `format_xml`) VALUES ('PROM.UA','" . htmlspecialchars($prom_ua) . "');";
		$sql[] = "INSERT INTO `" . DB_PREFIX . "product_feed_format` (`feed_format_name`, `format_xml`) VALUES ('GOOGLE MERCHANT','" . htmlspecialchars($google_merchant) . "');";
		$sql[] = "INSERT INTO `" . DB_PREFIX . "product_feed_format` (`feed_format_name`, `format_xml`) VALUES ('YML+Цвет+Размер','" . htmlspecialchars($yml2) . "');";
		$sql[] = "INSERT INTO `" . DB_PREFIX . "product_feed_format` (`feed_format_name`, `format_xml`) VALUES ('FACEBOOK.COM','" . htmlspecialchars($facebook) . "');";

		foreach ($sql as $_sql) {
			$this->db->query($_sql);
		}

		return TRUE;
	}

	public function upgrade()
	{
		$this->db->query("CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "product_feed_format` ( 
            `product_feed_format_id` int(11) NOT NULL AUTO_INCREMENT,  
            `feed_format_name` varchar(128) NOT NULL, 
            `format_xml` text NOT NULL,
            PRIMARY KEY (`product_feed_format_id`) 
            )  CHARACTER SET utf8 COLLATE utf8_general_ci;");

		return TRUE;
	}

	public function uninstall()
	{

		$this->db->query("DROP TABLE IF EXISTS `" . DB_PREFIX . "product_feed_format`");

		return TRUE;
	}

}

?>