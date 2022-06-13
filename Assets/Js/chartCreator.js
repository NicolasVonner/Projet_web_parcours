

 function chartCreatorPie(lab,back,datas,label,title){
 
    
  new Chart(document.getElementById("pie-chart"), {
    type: 'pie',
    data: {
      labels: lab,
      datasets: [{
        label: label,
        backgroundColor: back,
        data: datas
      }]
    },
    options: {
      responsive: true,
    maintainAspectRatio: false,
      title: {
        display: true,
        text:title ,
      },
      
    }
});
}

