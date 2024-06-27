/* Set the height of elements with the heroIndex, heroAbout, and heroPolyclinic classes to the height of the window */

$(document).ready(function () {
  $('.heroIndex, .heroAbout, .heroPolyclinic').height($(window).height());
});

/* Set the height of elements with the heroAccomplishments, and heroAdmission to half the height of the window */
$(document).ready(function () {
  $('.heroAccomplishments, .heroAdmission').height(3 * $(window).height() / 4);
});

/* Display slideshows */

var autoSlideIndex = 0;
var manualSlideIndex = 1;

/**
 * Shows the manual slides.
 * @param {number} n - The slide number to show.
 */
function showManualSlides(n) {
  let slides = document.getElementsByClassName("mySlides");
  if (slides.length === 0) return;
  manualSlideIndex = (n - 1 + slides.length) % slides.length + 1;
  for (let i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  slides[manualSlideIndex - 1].style.display = "block";
}

/**
* Displays a slideshow of images automatically.
 * @function
 * @returns {void}
 */
function showAutoSlides() {
  let slides = document.getElementsByClassName("mySlides_1");
  let dots = document.getElementsByClassName("dot_1");

  if (slides.length === 0) return;

  for (let i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }

  for (let i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }

  autoSlideIndex++;
  if (autoSlideIndex > slides.length) { autoSlideIndex = 1 }

  slides[autoSlideIndex - 1].style.display = "block";
  dots[autoSlideIndex - 1].className += " active";

  setTimeout(showAutoSlides, 2000);
}

/**
 * Moves the slide index by the given amount and updates the displayed slides.
 * @param {number} n - The amount to move the slide index by.
 */
function plusSlides(n) {
  showManualSlides(manualSlideIndex + n);
}

document.addEventListener("DOMContentLoaded", function () {

  showManualSlides(manualSlideIndex);

  var prevButton = document.querySelector("prev");
  var nextButton = document.querySelector("next");

  if (prevButton) {
    prevButton.addEventListener("click", function () {
      plusSlides(-1);
    });
  }

  if (nextButton) {
    nextButton.addEventListener("click", function () {
      plusSlides(1);
    });
  }
});

showAutoSlides();

/** Display available classes in the registration page */

document.querySelectorAll('input[name="cycle"]').forEach((cycleInput) => {
  cycleInput.addEventListener('click', function () {
    updateClassesFromElement(this);
    displayOptions(this);
  });
});

/**
 * Updates classes from an element.
 * @param {HTMLElement} element - The element to update classes from.
 */
function updateClassesFromElement(element) {
  const classesData = element.getAttribute('data-classes');
  const classesObject = JSON.parse(classesData);
  updateClasses(classesObject.classes);
}

/**
 * Animates the list items of a given list.
 * @param {string} listId - The ID of the list element.
 */
function animateListItems(listId) {
  var listItems = document.querySelectorAll('#' + listId + ' .expandable-list li');
  listItems.forEach(function (item, index) {
    // Reset styles to apply the animation again
    item.style.opacity = '0';
    item.style.transform = 'translateY(-20px)';

    // Apply the animation
    setTimeout(function () {
      item.style.opacity = '1';
      item.style.transform = 'translateY(0)';
    }, 100 * index);
  });
}

/**
 * Displays or hides the option list based on the selected school.
 * @param {HTMLElement} element - The element representing the selected school.
 */
function displayOptions(element) {
  const school = element.getAttribute('value');
  const optionList = document.getElementById('optionList');

  if (school === 'Humanite') {
    optionList.style.display = "block";
    animateListItems('optionList');
  } else {
    optionList.style.display = "none";
  }
}

/**
 * Animates the class list element by changing its opacity and transform properties.
 */
function animateClassList() {
  const classList = document.getElementById('classList');
  classList.style.opacity = '0';
  classList.style.transform = 'translateY(-20px)';
  classList.style.transition = 'opacity 0.5s, transform 0.5s';

  setTimeout(() => {
    classList.style.opacity = '1';
    classList.style.transform = 'translateY(0)';
  }, 500); 
}


/**
 * Updates the classes in the class list.
 * 
 * @param {Array} classes - The array of classes to update.
 */
function updateClasses(classes) {
  const classList = document.getElementById('classList');
  const classChoiceParagraph = document.getElementById('classChoiceParagraph');

  classList.innerHTML = "";
  classChoiceParagraph.style.display = "none";

  if (classes && classes.length > 0) {
    classChoiceParagraph.style.display = "block";
    classes.forEach(cls => {
      const listItem = document.createElement('li');
      const label = document.createElement('label');
      label.setAttribute('for', cls);
      label.textContent = cls;

      const input = document.createElement('input');
      input.setAttribute('type', 'radio');
      input.setAttribute('name', 'class');
      input.setAttribute('value', cls);
      input.id = cls;

      label.prepend(input);
      listItem.appendChild(label);
      classList.appendChild(listItem);
    });
    animateClassList(); 
  }
}



/** Back to top button */
const back_to_top_btn = document.getElementById("back_to_top_btn");

// When the user scrolls down 20px from the top of the document, show the button
window.addEventListener('scroll', function () {
  if (document.body.scrollTop > 60 || document.documentElement.scrollTop > 60) {
    back_to_top_btn.style.display = "block";
  } else {
    back_to_top_btn.style.display = "none";
  }
});

/**
 * Scrolls to the top of the page by setting the scrollTop property of both the document body and the document element to 0.
 */
function topFunction() {
  document.body.scrollTop = 0;
  document.documentElement.scrollTop = 0;
}

/** Form input validation */

document.addEventListener('DOMContentLoaded', () => {
  // Validation functions
  const validators = {
    name: value => value.length > 0,
    email: value => /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(value),
    phone: value => /^(\+243\s\d{3}-\d{3}-\d{3})$/.test(value),
    birthdate: value => {
      const birthYear = new Date(value).getFullYear();
      const currentYear = new Date().getFullYear();
      return (currentYear - birthYear) >= 3;
    },
    // The password validator will return an object with isValid and message properties
    password: value => {
      const conditions = [
        { test: pwd => pwd.length >= 8, message: "Password too short" },
        { test: pwd => /\d/.test(pwd), message: "Password should contain at least one digit" },
        { test: pwd => /[a-z]/.test(pwd), message: "Password should contain at least one lowercase letter" },
        { test: pwd => /[A-Z]/.test(pwd), message: "Password should contain at least one uppercase letter" },
        { test: pwd => /[^a-zA-Z0-9]/.test(pwd), message: "Password should contain at least one special character" },
      ];

      for (let condition of conditions) {
        if (!condition.test(value)) {
          return { isValid: false, message: condition.message };
        }
      }

      return { isValid: true, message: "Password is strong" };
    },

    passwordConfirmation: value => {
      const passwordValue = document.getElementById('password').value;
      if (value !== passwordValue) {
        return { isValid: false, message: "Passwords do not match" };
      }

      return { isValid: true, message: "Passwords match" }
    },
  };

  // Common function to update label colors and messages
  const updateValidationFeedback = (input, result) => {
    const label = document.querySelector(`label[for="${input.id}"]`);
    const originalLabelText = label.getAttribute('data-original-text');
    const isValid = typeof result === 'object' ? result.isValid : result;
    const message = typeof result === 'object' ? result.message : '';

    if (input.id === 'password' && isValid) {
      document.getElementById('confirm').style.display = 'block';
    }

    label.style.color = isValid ? 'green' : 'red';

    if (!originalLabelText) {
      label.setAttribute('data-original-text', label.textContent);
    }

    label.textContent = originalLabelText + (message ? `: ${message}` : '');
  };


  // Add event listeners to inputs for validation
  Object.keys(validators).forEach(key => {
    const input = document.getElementById(key);
    if (input) {
      input.addEventListener('input', () => {
        const result = validators[key](input.value);
        updateValidationFeedback(input, result);
      });
    }
  });

  // Form submission event
  const form = document.getElementById('myForm');
  if (form) {
    form.addEventListener('submit', event => {
      // Check all inputs for validity before allowing submission
      const isFormValid = Object.keys(validators).every(key => {
        const input = document.getElementById(key);
        if (input) {
          const result = validators[key](input.value);
          updateValidationFeedback(input, result);
          return typeof result === 'object' ? result.isValid : result;
        }
        return true;
      });

      if (!isFormValid) {
        event.preventDefault();
        alert('Please correct all errors before submitting.');
      }
    });
  }
});

/** Display news and achievements based on the category on the life and achievements pages */

/**
 * Filters the list of items based on the selected category.
 */
function filterList() {
  var selectedCategory = document.getElementById('categorySelect').value;
  var listItems = document.getElementsByClassName('row align-items-md-stretch');

  Array.from(listItems).forEach(function (item) {
    if (selectedCategory === 'all' || item.id === selectedCategory) {
      item.style.display = 'flex';
    } else {
      item.style.display = 'none';
    }
  });
}

/** Display admission conditions in the admission page */

/**
 * Displays or hides elements based on the provided cycle.
 * @param {string} cycle - The cycle to filter elements by.
 */
function displayConditions(cycle) {
  var listItems = document.getElementsByClassName('row align-items-md-stretch');
  Array.from(listItems).forEach(function (item) {
    if (cycle === item.id && item.style.display === 'none') {
      item.style.display = 'flex';
    } else {
      item.style.display = 'none';
    }
  });
}

/**
 * Toggles the visibility of an HTML element.
 * @param {string} elementId - The ID of the element to be displayed or hidden.
 */
function displayElement(elementId) {
  const div = document.getElementById(elementId);
  div.style.visibility = div.style.visibility === "hidden" ? "visible" : "hidden";
}

/**
 * Shows a toast message.
 */
function showToast() {
  var toastElement = document.querySelector('.toast');
  if (toastElement) {
    toastElement.style.visibility = 'visible';
    toastElement.style.opacity = '1'; // Make it visible
    setTimeout(function () {
      toastElement.style.opacity = '0'; // Fade out after 3 seconds
      setTimeout(function () {
        toastElement.style.visibility = 'hidden'; // Fully hide after fade out
      }, 500); // Wait for the transition to complete
    }, 3000);
  }
}

/**
 * Toggles the visibility of edit and display elements based on their IDs.
 * @param {Event} event - The event object.
 * @param {string} editId - The ID of the edit element.
 * @param {string} displayId - The ID of the display element.
 */
function displayEditElements(event, editId, displayId) {
  event.preventDefault();
  var editElement = document.getElementById(editId);
  var displayElement = document.getElementById(displayId);

  if (editElement && displayElement) {
    if (editElement.classList.contains('hidden')) {
      console.log('Toggling visibility of elements');
      editElement.classList.remove('hidden');
      editElement.classList.add('visible');
      displayElement.classList.add('hidden');
      displayElement.classList.remove('visible');
    } else {
      console.log('Toggling visibility of elements');
      editElement.classList.add('hidden');
      editElement.classList.remove('visible');
      displayElement.classList.remove('hidden');
      displayElement.classList.add('visible');
    }
  } else {
    console.error('Elements not found:', editId, displayId);
  }
}

/** Create animations */












