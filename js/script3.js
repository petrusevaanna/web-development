const postText = document.getElementById('postText');
const toggleBtn = document.getElementById('toggleBtn');

function needsTruncation() {
    const clone = postText.cloneNode(true);
    clone.style.maxHeight = 'none';
    clone.style.position = 'absolute';
    clone.style.visibility = 'hidden';
    clone.style.height = 'auto';
    clone.style.width = getComputedStyle(postText).width; 
    document.body.appendChild(clone);
    const fullHeight = clone.offsetHeight;
    document.body.removeChild(clone);
    const lineHeight = parseFloat(getComputedStyle(postText).lineHeight);
    const collapsedHeight = lineHeight * 2;
    return fullHeight > collapsedHeight;
}

function updateButtonText() {
    if (postText.classList.contains('expanded')) {
        toggleBtn.textContent = 'свернуть';
    } else {
        toggleBtn.textContent = 'ещё';
    }
}

function init() {
    if (needsTruncation()) {
        toggleBtn.style.display = 'inline-block';
        postText.style.maxHeight = (parseFloat(getComputedStyle(postText).lineHeight) * 2) + 'px';
        postText.style.overflow = 'hidden';
    } else {
        toggleBtn.style.display = 'none';
    }
    updateButtonText();
}

toggleBtn.addEventListener('click', () => {
    postText.classList.toggle('expanded');
    if (postText.classList.contains('expanded')) {
        postText.style.maxHeight = 'none';
        postText.style.overflow = 'visible';
    } else {
        postText.style.maxHeight = (parseFloat(getComputedStyle(postText).lineHeight) * 2) + 'px';
        postText.style.overflow = 'hidden';
    }
    updateButtonText();
});

init();
