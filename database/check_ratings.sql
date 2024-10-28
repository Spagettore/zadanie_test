SELECT art.header AS 'Статья',
u.name AS 'Пользователь',
r.rate AS 'Рейтинг'
FROM author
JOIN authors a ON author.id = a.author_id
JOIN article art ON a.article_id = art.id
LEFT JOIN rating r ON art.id = r.article_id
LEFT JOIN user u ON r.user_id = u.id
WHERE author.first_name = 'Дмитрий' AND author.family = 'Кузнецов' AND author.second_name = 'Александрович';