let tinhSelect = document.getElementById("tinh");
let huyenSelect = document.getElementById("huyen");
let xaSelect = document.getElementById("xa");

let tinhData = {}, huyenData = {}, xaData = {};

// Load JSON
async function loadJSON() {
  const [tinh, huyen, xa] = await Promise.all([
    fetch("js/tinh_tp.json").then(res => res.json()),
    fetch("js/quan_huyen.json").then(res => res.json()),
    fetch("js/xa_phuong.json").then(res => res.json())
  ]);
  tinhData = tinh;
  huyenData = huyen;
  xaData = xa;

  loadTinh();
}

function loadTinh() {
  for (let ma in tinhData) {
    let opt = new Option(tinhData[ma].name, ma);
    tinhSelect.add(opt);
  }
}

tinhSelect.addEventListener("change", () => {
  huyenSelect.length = 0;
  xaSelect.length = 0;
  let maTinh = tinhSelect.value;
  for (let ma in huyenData) {
    if (huyenData[ma].parent_code === maTinh) {
      huyenSelect.add(new Option(huyenData[ma].name, ma));
    }
  }
});

huyenSelect.addEventListener("change", () => {
  xaSelect.length = 0;
  let maHuyen = huyenSelect.value;
  for (let ma in xaData) {
    if (xaData[ma].parent_code === maHuyen) {
      xaSelect.add(new Option(xaData[ma].name, ma));
    }
  }
});

loadJSON();
