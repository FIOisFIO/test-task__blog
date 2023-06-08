
export function getPostCardTemp(postAuthorName, postDate, content, likeCount, userName) {

    const author = postAuthorName.split(' ');
    const user = userName.split(' ');
    const postAuthorInitials = author[0][0] + (author[1] ? author[1][0] : '');
    const userNameInitials = user[0][0] + user[1][0];

   return  ` <div class="post-card">
<div class="post-card__header">
    <div class="post-card__header_avatar">${postAuthorInitials}</div>
    <div class="post-card__header_info">
        <div class="post-card__header_title">${postAuthorName}</div>
        <div class="post-card__header_date">${postDate}</div>
    </div>
    
</div>
<div class="post-card__content">${content}</div>
<div class="post-card__info">
    <button class="like-button">
    <img class="like-img" src="public/accets/icons/like.png">
    <span class="like-count">${likeCount}</span>
    </button>
    <button class="comments-button"> <img class="comment-img" src="public/accets/icons/comment.png"></button>
</div>
<div class="comments-wrapper-disabled"></div>
<div class="post-card__comment-field">
    <div class="comment-author">${userNameInitials}</div>
    <textarea class="comment-input" type="comment" placeholder="Ваш комментарий" rows="3"></textarea>
</div>
<button class="comment-button">Отправить</button>
</div>`
}
