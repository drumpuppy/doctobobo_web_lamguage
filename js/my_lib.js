function bookAppointment() {
    const date = document.getElementById('appointmentDate').value;
    const time = document.getElementById('appointmentTime').value;
    const doctorId = localStorage.getItem('chosenDoctorId');

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "./phpDatabase/book_appointment.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            alert("Appointment booked!");
        }
    };
    xhr.send(`doctorId=${doctorId}&date=${date}&time=${time}`);
}


function setupDatepicker() {
    $("#appointmentDate").datepicker({
        minDate: 0,
        dateFormat: 'yy-mm-dd',
        onSelect: function(dateText) {
            var doctorId = localStorage.getItem('chosenDoctorId');
            $.post("./phpDatabase/get_available_slots.php", {doctorId: doctorId, date: dateText}, function(data) {
                console.log(data);
                var availableSlots = JSON.parse(data);
                var select = $('#appointmentTime');
                select.empty();
                availableSlots.forEach(function(slot) {
                    select.append($('<option></option>').attr('value', slot).text(slot));
                });
            });
        }
    });
}

function displaySearchResults(doctors) {
    const resultsContainer = document.getElementById("search-results");

    if (doctors.length === 0) {
        resultsContainer.innerHTML = '<p>Aucun resultat.</p>';
    } else {
        doctors.forEach(function(doctor) {
            const doctorDiv = document.createElement("div");
            doctorDiv.innerHTML = `
                <hr>
                <p><strong>Nom:</strong> ${doctor.Nom_Medecin}</p>
                <p><strong>Prenom:</strong> ${doctor.Prenom_Medecin}</p>
                <p><strong>Spécialité:</strong> ${doctor.Specialite}</p>`;
            console.log('User Type:', localStorage.getItem('user_type'));
            if (localStorage.getItem('user_type') === 'patient') {
                doctorDiv.innerHTML += `<a href="book_appointment.html?id=${doctor.idMedecin}" class="book-appointment-button">Prendre Rendez-vous</a>`;
            }
            doctorDiv.innerHTML += `<br>`;
            resultsContainer.appendChild(doctorDiv);

            const moreInfoDiv = document.createElement("div");
            moreInfoDiv.style.display = "none";
            moreInfoDiv.innerHTML = `
                <p><strong>Adresse:</strong> ${doctor.adresse}</p>
                <p><strong>Code Postal:</strong> ${doctor.code_postal}</p>
                <p><strong>Description:</strong> ${doctor.description}</p>`;
            const expandButton = document.createElement("button");
            expandButton.textContent = "Plus de détails";
            expandButton.addEventListener("click", function() {
                moreInfoDiv.style.display = moreInfoDiv.style.display === "none" ? "block" : "none";
            });
            doctorDiv.appendChild(expandButton);
            doctorDiv.appendChild(moreInfoDiv);
            resultsContainer.appendChild(doctorDiv);
            
        });
    }
}