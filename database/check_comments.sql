SELECT art.header AS 'Статья',
u.name AS 'Пользователь',
c.text AS 'Комментарий'
FROM author
JOIN authors a ON author.id = a.author_id
JOIN article art ON a.article_id = art.id
LEFT JOIN comments c ON art.id = c.article_id
LEFT JOIN user u ON c.user_id = u.id
WHERE author.first_name = 'Дмитрий' AND author.family = 'Кузнецов' AND author.second_name = 'Александрович';