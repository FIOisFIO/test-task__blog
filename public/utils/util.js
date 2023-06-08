export function createElem(elem, className='', content ) {

    const newElement = document.createElement(elem);

    newElement.className = className;
    newElement.innerText = content;

    return newElement
}