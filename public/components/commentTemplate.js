export function getCommentTemp (comment, commentAuthor) {

    const author = commentAuthor.split(' ');
    const postAuthorInitials = author[0][0] + (author[1] ? author[1][0] : '');

    return `
    <div class="comment-author">${postAuthorInitials}</div> 
    <span class='comment'>${comment}</span>`
}