import { createElem } from "../utils/util.js";
import { getCommentTemp } from "./commentTemplate.js";

export function createComment(comment, author) {
    let newComment = createElem('span', 'comment-wrapper');
    newComment.innerHTML = getCommentTemp(comment, author)

    return newComment
}