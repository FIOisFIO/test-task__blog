import { createElem } from "../utils/util.js";
import { createComment } from "./comment.js";
import { getPostCardTemp } from "./postCardTemplate.js";
import { curUser } from "./currentUser.js";



export function createPostCard(userName, date, content, likesCount, currentUser, id) {
    const card = createElem('div');
   
    card.innerHTML = getPostCardTemp(userName, date, content, likesCount, currentUser);

    let likeFlag = true;
    const likes = card.querySelector('.like-count');
    const likeButton = card.querySelector('.like-button');
    const commentsButton = card.querySelector('.comments-button');
    const commentsWrap = card.querySelector('.comments-wrapper-disabled');
    const addCommentButton = card.querySelector('.comment-button');
    const commentArea = card.querySelector('.comment-input');

    likeButton.addEventListener('click', onLikeToggle)
    commentsButton.addEventListener('click', onCommentsButtonClick)
    addCommentButton.addEventListener('click', onAddComment)

    function onLikeToggle() {
        fetch(`index.php/posts?id=${id}&likesCount=${likeFlag ? 1 : -1}`, {method: 'PUT'}).then(res => res.json())
    .then((data) => {
        likes.innerText = data.likesCount
    })
    likeFlag = !likeFlag
    }
    
    function onCommentsButtonClick() {
        fetch(`index.php/comments?postId=${id}`).then(res => res.json())
        .then((data) => {
            commentsWrap.classList.add('comments-wrapper');
            commentsWrap.classList.remove('comments-wrapper-disabled');
            data.forEach(comment => {
                addComment(comment)
            });
            commentsButton.remove()
        })
    }
    function onAddComment() {
        if(commentArea.value) {
            fetch(`index.php/comments?postId=${id}&text=${commentArea.value}&userId=${curUser.id}&userName=${curUser.name}`, {method: 'POST'}).then(res => res.json())
            .then((comment) => {
                if(commentsWrap.classList.contains('comments-wrapper-disabled')) {
                    onCommentsButtonClick()
                } else{
                    addComment(comment)
                }
                commentArea.value = '';
            })
        }
    }
    function addComment(comment) {
        commentsWrap.appendChild(createComment(comment.text, comment.userName))
    }

    return card
}