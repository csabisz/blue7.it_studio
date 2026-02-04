function sortTable(selectedColun, type) {
  let rows, switching, i, x, y, shouldSwitch, dir, switchCount = 0;
  let table = document.getElementById("table");
  switching = true;
  dir = "asc";

  while (switching) {
    switching = false;
    rows = table.rows;
    for (i = 1; i < (rows.length - 1); i++) {
      shouldSwitch = false;
      x = rows[i].getElementsByTagName("TD")[selectedColun];
      y = rows[i + 1].getElementsByTagName("TD")[selectedColun];

      if (type === 'text') {
        if (dir === "asc") {
          if (x.innerText.toLowerCase() > y.innerText.toLowerCase()) {
            shouldSwitch = true;
            break;
          }
        } else if (dir === "desc") {
          if (x.innerText.toLowerCase() < y.innerText.toLowerCase()) {
            shouldSwitch = true;
            break;
          }
        }
      } else if (type === 'number') {
        if (dir === "asc") {
          if (parseInt(x.innerText) > parseInt(y.innerText)) {
            shouldSwitch = true;
            break;
          }
        } else if (dir === "desc") {
          if (parseInt(x.innerText) < parseInt(y.innerText)) {
            shouldSwitch = true;
            break;
          }
        }
      } else {
        console.log('Wrong type for sorting');
      }

    }
    if (shouldSwitch) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      switchCount++;
    } else {
      if (switchCount === 0 && dir === "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}

function searchTable(selectedColun, input) {

  let rows, i, x, y, shouldSwitch, dir, switchCount = 0;
  let table = document.getElementById("table");


  for (let row of Array.from(table.rows)) {

    console.log(row);
    let cell = row.getElementsByTagName("TD")[selectedColun];

    if (cell){
      if (cell.innerText.toLowerCase().includes(input.toLowerCase())) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    }
  }
}

