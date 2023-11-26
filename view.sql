CREATE OR REPLACE VIEW  itemsview AS
SELECT items.* , categories.* FROM items 
INNER JOIN  categories on  items.items_cat = categories.categories_id ; 

CREATE OR REPLACE VIEW MyFavorite AS
SELECT favorite.* , items.* , users.users_id from favorite
INNER JOIN users ON users.users_id = favorite.favorite_userid
INNER JOIN items ON items.item_id = favorite.favorite_itemid


CREATE or REPLACE VIEW cartview as 
SELECT 
  cart.cart_userid,
  cart.cart_itemid,
  items.*,
  COUNT(*) as countitems,
  SUM(items.item_price - (items.item_price * items.item_discount / 100)) as itemsprice
FROM 
  cart 
INNER JOIN 
  items ON items.item_id = cart.cart_itemid
WHERE card_orders = 0
GROUP BY 
 cart.cart_userid, cart.cart_itemid

 CREATE or REPLACE VIEW orderView as 
SELECT 
  orders.*,address.*
FROM 
  orders 
LEFT JOIN 
  address ON address.address_id = orders.orders_address


CREATE or REPLACE VIEW orderDetails as 
SELECT 
  cart.cart_userid,
  cart.cart_itemid,
  cart.card_orders
  items.*,
  COUNT(*) as countitems,
  SUM(items.item_price - (items.item_price * items.item_discount / 100)) as itemsprice,
  orderView.*
FROM 
  cart 
INNER JOIN 
  items ON items.item_id = cart.cart_itemid
WHERE card_orders != 0
GROUP BY 
 cart.cart_userid, cart.cart_itemid, cart.card_orders