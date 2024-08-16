import './bootstrap';

import flatpickr from "flatpickr";
import { Spanish } from "flatpickr/dist/l10n/es.js"


document.addEventListener('DOMContentLoaded', () => {
  // Flatpickr
  flatpickr('.datepicker', {
    mode: 'single',
    static: true,
    monthSelectorType: 'static',
    maxDate: 'today',
    dateFormat: "Y-m-d",
    locale: Spanish,
  });

  // Flatpickr 2
  flatpickr('.datepicker2', {
    mode: 'single',
    static: true,
    monthSelectorType: 'static',
    dateFormat: "Y-m-d",
    minDate: 'today',
    locale: Spanish,
  });

  // busca todas las clases flatpickr-wrapper y agrega la clase w-full
  const flatpickrWrappers = document.querySelectorAll('.flatpickr-wrapper');
  if (flatpickrWrappers.length > 0) {
    flatpickrWrappers.forEach((flatpickrWrapper) => {
      flatpickrWrapper.classList.add('w-full');
    });
  }
});

