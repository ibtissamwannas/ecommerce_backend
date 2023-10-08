CREATE OR REPLACE VIEW  itemsview AS
SELECT items.* , categories.* FROM items 
INNER JOIN  categories on  items.items_cat = categories.categories_id ; 

CREATE OR REPLACE VIEW MyFavorite AS
SELECT favorite.* , items.* , users.users_id from favorite
INNER JOIN users ON users.users_id = favorite.favorite_userid
INNER JOIN items ON items.item_id = favorite.favorite_itemid