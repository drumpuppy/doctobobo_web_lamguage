function displayAppointments(response) {
    const appointments = response.appointments;
    const userType = response.userType;
    const appointmentsContainer = document.getElementById("appointments");

    if (appointments.length === 0) {
        appointmentsContainer.innerHTML = '<p>Aucun rendez-vous trouvé.</p>';
    } else {
        appointments.forEach(function(appointment) {
            const appointmentDiv = document.createElement("div");
            const dateTime = appointment.DateHeure;
            const doctorName = userType === 'patient' ? appointment.Nom_Medecin : appointment.Nom_Patient;
            const address = appointment.adresse;
            
            if(dateTime) {
                const dateTimeParts = dateTime.split(' ');
                const date = dateTimeParts[0];
                const time = dateTimeParts[1];

                if (userType === 'docteur') {
                    appointmentDiv.innerHTML = `
                        <p>Date: ${date}</p>
                        <p>Heure: ${time}</p>
                        <p>Patient: ${appointment.Prenom_Patient} ${appointment.Nom_Patient}</p>
                        <button class="cancel-btn" data-id="${appointment.idConsultation}">Annuler</button>
                        <hr>
                    `;
                } else {
                    appointmentDiv.innerHTML = `
                    <p>Date: ${date}</p>
                    <p>Heure: ${time}</p>
                    <p>Docteur: ${appointment.Prenom_Medecin} ${appointment.Nom_Medecin}</p>
                    <p>Addresse: ${appointment.adresse}</p>
                    <button class="cancel-btn" data-id="${appointment.idConsultation}">Annuler</button>
                    <hr>
                `;
                }
            } else {
                appointmentDiv.innerHTML = `
                    <p>No Appointment Data Available</p>
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
        appointments.forEach(function(appointment) {
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
                        <p>Medicaments: ${appointment.Medicaments}</p>
                        <p>Jours d'arrêts maladie: ${appointment.NbrJours}</p>
                        <hr>
                    `;
                } else {
                    appointmentDiv.innerHTML = `
                    <p>Date: ${date}</p>
                        <p>Heure: ${time}</p>
                        <p>Docteur: ${appointment.Prenom_Medecin} ${appointment.Nom_Medecin}</p>
                        <p>Addresse: ${appointment.adresse}</p>
                        <p>Medicaments: ${appointment.Medicaments}</p>
                        <p>Jours d'arrêts maladie: ${appointment.NbrJours}</p>
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