import { Controller } from 'stimulus';

export default class extends Controller {

  static values = {
    proto: String,
    index: Number
  };
  

  removeTableRowFromWithinTD(event) {
    event.currentTarget.parentNode.parentNode.remove();
  }


  addTableRowFromPrototype() {
    let newRow = this.element.querySelector('tbody').insertRow(-1);
    let newRowString = this.protoValue.replace(/__name__/g, `horseThumb_${this.indexValue}`);
    this.indexValue++;
    let parsed = new DOMParser().parseFromString(newRowString, "text/html").documentElement.textContent;
    newRow.innerHTML = parsed;
  }

}