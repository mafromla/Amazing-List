
// Mobile Menu Toggle
function toggleMobileMenu() {
    const navLinks = document.getElementById('primaryNav');
    if (navLinks.style.display === 'flex') {
      navLinks.style.display = 'none';
    } else {
      navLinks.style.display = 'flex';
    }
  }
  
  // Toggle User Profile Dropdown
  function toggleProfileMenu() {
    const userDropdown = document.getElementById('userDropdown');
    userDropdown.classList.toggle('show');
  }
  
  // Close profile menu if user clicks outside
  window.onclick = function(event) {
    if (!event.target.matches('.user-btn')) {
      const dropdowns = document.getElementsByClassName("user-profile-dropdown");
      for (let i = 0; i < dropdowns.length; i++) {
        if (dropdowns[i].classList.contains('show')) {
          dropdowns[i].classList.remove('show');
        }
      }
    }
  }

// Toggle Dropdown Menu
function toggleDropdownMenu() {
  const dropdown = document.querySelector('.dropdown');
  dropdown.classList.toggle('show');
}

// Close dropdown menu if user clicks outside
window.onclick = function(event) {
  if (!event.target.matches('.dropdown > a')) {
    const dropdowns = document.getElementsByClassName("dropdown");
    for (let i = 0; i < dropdowns.length; i++) {
      if (dropdowns[i].classList.contains('show')) {
        dropdowns[i].classList.remove('show');
      }
    }
  }
}

// Login Modal
  function openModal() {
    const modal = document.getElementById('loginModal');
    modal.classList.add('show');
  }
  
  function closeModal() {
    const modal = document.getElementById('loginModal');
    modal.classList.remove('show');
  }
  
  // close the modal if the user clicks outside the .modal-content
  window.addEventListener('click', function(e) {
    const modal = document.getElementById('loginModal');
    if (e.target === modal) {
      closeModal();
    }
  });



  function sortItems() {
    var sortValue = document.getElementById('sortBy').value;
    window.location.href = "buypage.php?sort=" + sortValue;
}

// Message Modal
function openMessageModal(itemId, receiverId, listingType) {
  document.getElementById('messageModal').style.display = 'block';
  document.getElementById('itemId').value = itemId;
  document.getElementById('receiverId').value = receiverId;
  document.getElementById('listingType').value = listingType;

  if (listingType === 'TRADE') {
    document.getElementById('offerSection').style.display = 'block';
  } else {
    document.getElementById('offerSection').style.display = 'none';
  }
}

function closeMessageModal() {
  document.getElementById('messageModal').style.display = 'none';
}