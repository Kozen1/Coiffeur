// let details = document.querySelectorAll('.details');

// details.forEach(function(container) {
//   container.addEventListener('click', function() {
//     let summary = container.querySelector('.summary');
//     let arrow = container.querySelector('.arrow');
//     let text = container.querySelector('.text');
//     let summary1 = container.querySelector('.summary1');
//     let arrow1 = container.querySelector('.arrow1');
//     let text1 = container.querySelector('.text1');

//     if (text.style.display === 'none') {
//       text.style.display = 'block';
//       summary.innerHTML = 'Moins de détails <span class="arrow">&#9650;</span>';
//     } else {
//       text.style.display = 'none';
//       summary.innerHTML = 'Plus de détails <span class="arrow">&#9660;</span>';
//     }

//   });
// });

document.querySelectorAll('.more-details-link').forEach(link => {
  link.addEventListener('click', function(event) {
    event.preventDefault();
    let text = this.parentNode.nextElementSibling;
    if (text.style.display === 'none') {
      text.style.display = 'block';
      this.innerHTML = '&#9650;';
    } else {
      text.style.display = 'none';
      this.innerHTML = '&#9660;';
    }
  });
});



