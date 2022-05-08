let inputType = new Map([
    ['varchar', 'text'],
    ['int', 'number'],
]);
let configData = new Map();

$.ajax({url: "http://localhost:8888/create_parcours/get_list_activity.php", success: function(result){
    configData = new Map(JSON.parse(result));
    configData.forEach((config,activity)=>{
        $('<a>', {
            text: activity,
            class: "dropdown-item",
            click: function() {openConfig({name:activity},true)}
        }).appendTo("#activity-choice");
    });
}});

$(document).on('click', '#add-activity', function() { // show modal
    $("#myModal").css("display", "block");
    $("html").css("overflow","hidden");
    $("#select-activity").html(" Activities ");
    $("#select-activity").prop("disabled",false);
    $("form").empty();
    $("#create-activity").show();
    $("#create-activity").html("Create");
    $('#create-activity').attr("onclick",`sendActivityData()`);
});

const viewActivity = (actIndex) => {
    $("#myModal").css("display", "block");
    $("html").css("overflow","hidden");
    $("#select-activity").prop("disabled",true);
    openConfig(parcour.positions[spotIndex].activity[actIndex],false);
    $("#create-activity").hide();
};

const editActivity = (actIndex) => {
    $("#myModal").css("display", "block");
    $("html").css("overflow","hidden");
    $("#select-activity").prop("disabled",false);
    openConfig(parcour.positions[spotIndex].activity[actIndex],true);
    $("#create-activity").show();
    $("#create-activity").html("Edit");
    $('#create-activity').attr("onclick",`sendActivityData(${parcour.positions[spotIndex].activity[actIndex].id})`);
};

$(document).on('click', '.closeModal', function() { // close modal
    $("#myModal").css("display", "none");
    $("html").css("overflow","auto");
});

const getInputType = (type) => {
    for (const [typeDB, value] of inputType.entries()) {
        if (type.includes(typeDB))
            return inputType.get(typeDB);
    }
};

const openConfig = (activity, canEdit) => {
    $("#select-activity").html(activity.name);
    $("#submit-activity").prop("disabled",false);
    $('form').empty();
    console.log(configData)
    console.log(activity)
    configData.get(activity.name).slice(1).forEach((activity,index) => {
        $('form').append(`
            <div class="form-group col-sm-6">
                <label for="${activity.Field}">${activity.Field}</label>
                <input type="${getInputType(activity.Type)}" class="form-control" id="${activity.Field}" placeholder="${activity.Field}" ${canEdit ? "" : "readonly"}>
            </div>
        `);
    });
    if (activity.data !== undefined)
    {
        console.log(activity)
        $("form").find(':input').each(function(index){
            let input = $(this); // This is the jquery object of the input, do what you will
            input.val(activity.data[index].value);
        });
    }
};


const sendActivityData = (id) => {
    let formData = $("form").find(':input').toArray().map((input)=>{
        return {"name":input.id,"value":input.value};
    }); // on fait un array quin contient toutes les données des champs

    let allFilled = formData.every((field) => {
        return field.value !== "";
    }); // on vérifie si tous les champs sont remplis

    let objectFieldInfo = {
        "name": $("#select-activity").text(),
        "data": formData
    };

    if (allFilled) {
        console.log(allFilled)
        let currentSpotIndex = parcour.positions.findIndex((element)=>element.placeName === adress.innerText);
        if (currentSpotIndex != -1)
        {
            if (id !== undefined) // si le paramètre id existe bel et bien alors on modifie l'activité
            {
                let currentActivityIndex = parcour.positions[currentSpotIndex].activity.findIndex((activity)=>activity.id == id);
                parcour.positions[currentSpotIndex].activity[currentActivityIndex].data = formData;
            }
            else
            {
                objectFieldInfo.id = Math.floor(Math.random() * 100000).toString();
                parcour.positions[currentSpotIndex].activity.push(objectFieldInfo);
            }
            displayActivityList(parcour.positions[currentSpotIndex].activity);
            $("form").find("input[type=text], textarea").val("");
        }
    }
    else
    {
        console.log("nope");
    }
};

const removeActivity = (index) => {
    activityList.removeChild(activityList.children[index]);
    parcour.positions[spotIndex].activity.splice(index,1);
    for (let i = 0; i < parcour.positions[spotIndex].activity.length; i++)
    {
        let activityElement = activityList.children[i];
        console.log(activityElement);
        activityElement.firstElementChild.onclick = function() {viewActivity(i)};
        activityElement.lastElementChild.firstElementChild.onclick = function() {editActivity(i)};
        activityElement.lastElementChild.lastElementChild.onclick = function() {removeActivity(i)};
        activityElement.firstElementChild.firstElementChild.innerText = i+1;
    }
    displayAddGamesButton();
};

const displayActivityList = (actList) => { // affiche les activités dans la page
    // console.log("On souhaite afficher la liste des activités de la position =>"+index);
    activityList.innerHTML = "";
    for (let i = 0; i < actList.length; i++)
    {
        let div = document.createElement("div");
        div.className = "activity d-flex justify-content-between align-items-center bg-secondary rounded-3 mt-1 mb-1";
        div.innerHTML = `
            <div class="d-flex justify-content-between w-100 h-100" onclick="viewActivity(${i})">
                <p class="font-weight-bold m-1">${i + 1}.</p>
                <p class="m-1">${actList[i].name} - ${actList[i].id}</p>
            </div>
            <div class="d-flex justify-content-center h-100">
                <button type="button" class="btn btn-secondary text-center" onclick="editActivity(${i})"><i class="mdi mdi-border-color m-0"></i></button>
                <button type="button" class="btn btn-danger text-center" onclick="removeActivity(${i})">X</button>
            </div>
        `;
        activityList.appendChild(div);
    }
};