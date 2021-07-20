window.addEventListener('DOMContentLoaded', () => {
    const closePopupButton = document.getElementById('close-button');
    const badgeMoreButton = document.getElementById('opinions-badge-more');
    const opinionsWrapper = document.getElementById('opinions-wrapper');
    const opinionsBadge = document.getElementById('opinions_badge');

    opinionsBadge.addEventListener('mouseenter', () => {
        badgeMoreButton.style.width = '20px';
        badgeMoreButton.style.height = '20px';
    })
    opinionsBadge.addEventListener('mouseleave', () => {
        badgeMoreButton.style.width = '16px';
        badgeMoreButton.style.height = '16px';
    })

    
    const openPopup = () => {
        opinionsBadge.style.display = 'none';
        opinionsWrapper.style.display = 'block';
    }

    opinionsBadge.addEventListener('click', openPopup)

    const closePopup = () => {
        opinionsWrapper.style.display = 'none';
        opinionsBadge.style.display = 'block';
    }


    closePopupButton.addEventListener('click', closePopup);
})