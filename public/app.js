import { createPostCard } from "./components/postCard.js";
import { curUser } from "./components/currentUser.js";

const postWrapper = document.querySelector(".posts-wrapper");
const publicPost = document.querySelector('.post-create_button');
const postInput = document.querySelector('.post-input');
const contentWrapper = document.querySelector('.content-wrapper');
const pageSize = 5;
let offset = 0;

publicPost.addEventListener('click', addPost)
contentWrapper.addEventListener('scroll', scrollControll)
postInput.addEventListener('keyup', () => postInput.innerHTML ? postInput.classList.add('dirty') : postInput.classList.remove('dirty'))

 initPosts()
    
     function initPosts() {
        fetch(`index.php/posts?limit=${pageSize}&offset=${offset}`).then(res => res.json())
        .then((data) => {
        if(data?.length) {
            data.forEach(post => {
                appendPost(post)
            });
        }
    }
     )
 }

    function appendPost(post) {
        postWrapper.appendChild(createPostCard(post.userName, post.date, post.text, post.likesCount, curUser.name, post.id))
    }
    function insertPostBefore(post) {
        postWrapper.insertBefore(createPostCard(post.userName, post.date, post.text, post.likesCount, curUser.name, post.id), postWrapper.firstChild)
    }

    function addPost() {
        let postText = postInput.innerHTML;
        if (postText !=='') {
            fetch("index.php/posts", {method: 'POST', 
            body: JSON.stringify({text: postText, userName: curUser.name, userId: curUser.id})})
            .then(res => res.json())
            .then((data) => {
                insertPostBefore(data) 
                postInput.innerHTML = '';
                postInput.classList.remove('dirty')
            })
        }
      
    }
    function scrollControll(e) {
        const screenHeight = window.innerHeight
        if ((e.target.scrollHeight - e.target.scrollTop - screenHeight) <= 300) {
            offset += pageSize 
            initPosts()
            }
    }
  