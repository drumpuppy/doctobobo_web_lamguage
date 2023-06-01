function displayAppointments(response) {
    const appointments = response.appointments;
    const userType = response.userType;
    const appointmentsContainer = document.getElementById("appointments");

    if (appointments.length === 0) {
        appointmentsContainer.innerHTML = '<p>Aucun rendez-vous trouvé.</p>';
    } else {
        appointments.forEach(function(appointment, index) {
            console.log(appointment);
            const appointmentDiv = document.createElement("div");
            const dateTime = appointment.DateHeure;
            
            if(dateTime) {
                const dateTimeParts = dateTime.split(' ');
                const date = dateTimeParts[0];
                const time = dateTimeParts[1];

                if (userType === 'docteur') {
                    appointmentDiv.innerHTML = `
                        <p>Date: ${date}</p>
                        <p>Heure: ${time}</p>
                        <p>Patient: ${appointment.Prenom_Patient} ${appointment.Nom_Patient}</p>
                        <button class="edit-prescription-btn" onclick="editPrescription(${index})">Editer une prescription</button>
                        <button class="view-prescription-btn" onclick="toggleDetails(${index})">Afficher la prescription</button>
                        <button class="cancel-btn" data-id="${appointment.idConsultation}">Annuler</button>
                        <div id="details-${index}" style="display: none;">
                            <p id="motif-${index}" contenteditable="true">Motif: ${appointment.motif || ''}</p>
                            <p id="description-${index}" contenteditable="true">Description: ${appointment.description || ''}</p>
                            <p>Medicaments: ${appointment.Medicaments || ''}</p>
                            <p>Jours d'arrêts maladie: ${appointment.NbrJours || ''}</p>
                        </div>
                        <div id="edit-${index}" style="display: none;">
                            <form id="edit-form-${index}">
                                <br>
                                <br>
                                <label for="medicaments">Medicaments:</label>
                                <input type="text" id="medicaments-${index}" name="medicaments" value="${appointment.Medicaments}">
                                <br>
                                <br>
                                <label for="nbrjours">Jours d'arrêts maladie:</label>
                                <input type="number" id="nbrjours-${index}" name="nbrjours" value="${appointment.NbrJours}">
                                <br>
                                <br>
                                <button type="button" onclick="saveChanges(${index}, ${appointment.Prescription_idPrescription})">Validate</button>
                                <br>
                                <br>
                            </form>
                        </div>
                        <hr>
                    `;
                } else {
                    appointmentDiv.innerHTML = `
                        <p>Date: ${date}</p>
                        <p>Heure: ${time}</p>
                        <p>Docteur: ${appointment.Prenom_Medecin} ${appointment.Nom_Medecin}</p>
                        <p>Addresse: ${appointment.adresse}</p>
                        <button class="view-prescription-btn" onclick="toggleDetails(${index})">Afficher la prescription</button>
                        <button class="cancel-btn" data-id="${appointment.idConsultation}">Annuler</button>
                        <div id="details-${index}" style="display: none;">
                            ${appointment.Medicaments || appointment.NbrJours ?
                            `<p>Medicaments: ${appointment.Medicaments}</p>
                            <p>Jours d'arrêts maladie: ${appointment.NbrJours}</p>` : 
                            `<p>Le médecin ${appointment.Prenom_Medecin} ${appointment.Nom_Medecin} n'a pas encore renseigné de prescription</p>`}
                        </div>
                        <hr>
                    `;
                }
                
            } else {
                appointmentDiv.innerHTML = `
                    <p>Aucun rendez-vous disponible</p>
                    <hr>
                `;
            }

            appointmentsContainer.appendChild(appointmentDiv);
        });
    }
    const cancelButtons = document.querySelectorAll(".cancel-btn");
    cancelButtons.forEach(btn => {
        btn.addEventListener("click", function() {
            cancelAppointment(this.dataset.id);
        });
    });
}


function displayAppointments2(appointments, userType) {
    const appointmentsContainer = document.getElementById("appointments");

    if (appointments.length === 0) {
        appointmentsContainer.innerHTML = '<p>Aucun rendez-vous trouvé.</p>';
    } else {
        appointments.forEach(function(appointment, index) {
            console.log(appointment);
            const appointmentDiv = document.createElement("div");
            const dateTime = appointment.DateHeure;
            
            if(dateTime) {
                const dateTimeParts = dateTime.split(' ');
                const date = dateTimeParts[0];
                const time = dateTimeParts[1];

                if (userType === 'docteur') {
                    appointmentDiv.innerHTML = `
                        <p>Date: ${date}</p>
                        <p>Heure: ${time}</p>
                        <p>Patient: ${appointment.Prenom_Patient} ${appointment.Nom_Patient}</p>
                        <button class="edit-prescription-btn" onclick="editPrescription(${index})">Editer une prescription</button>
                        <button class="view-prescription-btn" onclick="toggleDetails(${index})">Afficher la prescription</button>
                        <div id="details-${index}" style="display: none;">
                            <p>Medicaments: ${appointment.Medicaments}</p>
                            <p>Jours d'arrêts maladie: ${appointment.NbrJours}</p>
                        </div>
                        <div id="edit-${index}" style="display: none;">
                            <form id="edit-form-${index}">
                                <br>
                                <br>
                                <label for="medicaments">Medicaments:</label>
                                <input type="text" id="medicaments-${index}" name="medicaments" value="${appointment.Medicaments}">
                                <br>
                                <br>
                                <label for="nbrjours">Jours d'arrêts maladie:</label>
                                <input type="number" id="nbrjours-${index}" name="nbrjours" value="${appointment.NbrJours}">
                                <br>
                                <br>
                                <button type="button" onclick="saveChanges(${index}, ${appointment.Prescription_idPrescription})">Valider</button>
                                <br>
                                <br>
                            </form>
                        </div>
                        <hr>
                    `;
                } else {
                    appointmentDiv.innerHTML = `
                        <p>Date: ${date}</p>
                        <p>Heure: ${time}</p>
                        <p>Docteur: ${appointment.Prenom_Medecin} ${appointment.Nom_Medecin}</p>
                        <p>Addresse: ${appointment.adresse}</p>
                        <button class="view-prescription-btn" onclick="toggleDetails(${index})">Afficher la prescription</button>
                        <div id="details-${index}" style="display: none;">
                            <p>Medicaments: ${appointment.Medicaments}</p>
                            <p>Jours d'arrêts maladie: ${appointment.NbrJours}</p>
                        </div>
                        <hr>
                    `;
                }
            } else {
                appointmentDiv.innerHTML = `
                    <p>Aucun rendez-vous disponible</p>
                    <hr>
                `;
            }

            appointmentsContainer.appendChild(appointmentDiv);
        });
    }
}

function toggleDetails(index) {
    const detailsDiv = document.getElementById(`details-${index}`);
    detailsDiv.style.display = detailsDiv.style.display === 'none' ? 'block' : 'none';
}

function editPrescription(index) {
    const editDiv = document.getElementById(`edit-${index}`);
    editDiv.style.display = 'block';
}

function saveChanges(index, appointmentId) {
    const medicamentsInput = document.getElementById(`medicaments-${index}`);
    const nbrjoursInput = document.getElementById(`nbrjours-${index}`);
    
    const data = {
        medicaments: medicamentsInput.value,
        nbrjours: nbrjoursInput.value,
        appointmentId: appointmentId
    };
    
    $.ajax({
        type: "POST",
        url: "./phpDatabase/update_prescription.php",
        data: data,
        success: function(response) {
            console.log(response);
            if (response.success) {
                alert("Prescription has been updated successfully.");

                location.reload();
            } else {
                alert("Failed to update prescription.");
            }
        },
        error: function() {
            alert("An error occurred.");
        }
    });
}


function cancelAppointment(appointmentId) {
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "./phpDatabase/cancel_appointment.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    location.reload();
                } else {
                    alert('Une erreur est survenu pendant l\'annulation du rendez-vous. Veuillez réessayer');
                }
            }
        }
    };
    const data = 'appointment_id=' + encodeURIComponent(appointmentId);
    xhr.send(data);
}