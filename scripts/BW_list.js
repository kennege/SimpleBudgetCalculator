class BW_list {
  constructor(){
    this.ping();
  }

  create(bw_pairs) { 
    this.bw_pairs = bw_pairs;
    // generate bucket list for choosing weights
    let block = document.getElementById("bucket_box"); 
    let bl = document.getElementById("bucketList");  
    let para = document.createElement("div");
    while(bl.firstChild){
      bl.removeChild(bl.firstChild );
    }
    para.innerHTML = "<p>Input weights so the sum equals 1. </p>";
    para.id = "weightpara";
    bl.appendChild(para);
    for (let i=0;i<Object.keys(bw_pairs).length;i++){
      if (!bw_pairs[i].bucket.includes("income")) {
        let node = document.createElement("div");
        if ((bw_pairs[i].weight == 0) || (isNaN(bw_pairs[i].weight)))
        {
          node.innerHTML = `<li class="newBucket"> <input name="chosenBucket" id="${bw_pairs[i].bucket}" placeholder="Add weight. Eg. 0.3"> ${bw_pairs[i].bucket}</li>`; 
        }
        else
        {
          node.innerHTML = `<li class="newBucket"> <input name="chosenBucket" id="${bw_pairs[i].bucket}" value="${bw_pairs[i].weight}"> ${bw_pairs[i].bucket}</li>`;
        }
        bl.appendChild(node);
      }
    }
    let chosenBuckets = document.getElementsByClassName("newBucket");
    for (let i=0;i<chosenBuckets.length;i++){
      chosenBuckets[i].style.listStyleType = "none";
    }
    document.getElementById('bucket_box').style.display = 'block';
    document.getElementById('done_button').style.display = 'block';
  }

  ping() {
    console.log("I am a BW_list");
  }
}