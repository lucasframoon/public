<div class="ui modal" id="modalAttendance">
    <i class="close icon"></i>
    <div class="header">
        Selecione o dia e horário
    </div>

    <div class="content" id="contentAttendance" style="text-align: -webkit-center; padding-top:1px;">

        <div class="ui input left icon">
            <i class="calendar icon"></i>
            <input name="dtAttendance" id="dtAttendance" type="text" placeholder="DD/MM/YYYY" onchange="console.log('testeee')">
        </div>

        <div class="ui form" style="margin-top: 1rem;">

            <!-- <label>Horários disponíveis: </label> -->
            <div class="ui two column grid">
                <div class="column">
                    <div class="grouped fields" id="columnLeft" style="padding-top: 0px">
                        <div></div>
                    </div>
                </div>

                <div class="column">
                    <div class="grouped fields" id="columnRight" style="padding-top: 0px">
                        <div></div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="actions" style="padding: 2px">
        <div class="ui black deny button" id="btnReturnToBarbers" onclick="returnToBarbers()">
            Voltar
        </div>
        <div class="ui positive right labeled icon button" onclick="saveAttendance()">
            Salvar
            <i class="checkmark icon"></i>
        </div>
    </div>
</div>

<script>
    var today = new Date();

    $("#dtAttendance")
        .closest("div.input")
        .calendar({
            type: "date",
            text: {
                days: [
                    "DOMINGO",
                    "SEGUNDA",
                    "TERÇA",
                    "QUARTA",
                    "QUINTA",
                    "SEXTA",
                    "SÁBADO"
                ],
                months: [
                    "JANEIRO",
                    "FEVEREIRO",
                    "MARÇO",
                    "ABRIL",
                    "MAIO",
                    "JUNHO",
                    "JULHO",
                    "AGOSTO",
                    "SETEMBRO",
                    "OUTUBRO",
                    "NOVEMBRO",
                    "DEZEMBRO"
                ],
                monthsShort: [
                    "JAN",
                    "FEV",
                    "MAR",
                    "ABR",
                    "MAI",
                    "JUN",
                    "JUL",
                    "AGO",
                    "SET",
                    "OUT",
                    "NOV",
                    "DEZ",
                ],
                today: "HOJE",
                now: "AGORA"
            },
            minDate: new Date(today.getFullYear(), today.getMonth(), today.getDate()),
            maxDate: new Date(today.getFullYear(), today.getMonth(), today.getDate() + 30),
            formatter: {
                date: function(date, settings) {
                    if (!date) return "";
                    var day = date.getDate();
                    var month = (date.getMonth() + 1).length < 2 ? (date.getMonth() + 1) : "0" + (date.getMonth() + 1);
                    var year = date.getFullYear();
                    return day + "/" + month + "/" + year;
                },
            },
            onChange: function(date, text, mode) {
                getAllAttendanceAvailableTime(text, $('#modalBarbers .image img').attr('id'));
                console.log(text);
            },

        });


    function returnToBarbers() {
        $('#modalBarbers .image img').attr('id', '');
        $('#modalBarbers').transition('fade right')
        $('#modalAttendance').transition('fade left')
    }

    function getAllAttendanceAvailableTime(rawDtAttendance = '', idBarber = '') {

        if (rawDtAttendance == null || idBarber == null) {
            return false;
        }

        data = new FormData();
        data.append('rawDtAttendance', rawDtAttendance);
        data.append('idBarber', idBarber);

        new Promise(function(resolve, reject) {
            $.ajax({
                url: "./control/getAllAttendanceAvailableTime.php",
                type: "POST",
                data: data,
                dataType: "json",
                async: true,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    createRadioAvaliableTime(response.RESULT);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    return reject(errorThrown);
                },
            });
        });
    }

    /**
     * Cria os radio buttons de horários disponíveis
     * @param {array} times Array de horários disponíveis
     * 
     */
    function createRadioAvaliableTime(times = []) {

        let radioLeft = '';
        let radioRight = '';
        half = Math.round(times.length / 2); //metade do array para dividir na tela 
        times.forEach(time => {

            if (times.indexOf(time) < half) {

                radioLeft +=
                    `<div class="field">
                        <div class="ui radio checkbox">
                            <input type="radio" name=${time} value=${time} onclick="console.log(this)">
                            <label>${time.substring(0,5)}</label>
                        </div>
                    </div>`;
            } else {
                radioRight +=
                    `<div class="field">
                        <div class="ui radio checkbox">
                            <input type="radio" value=${time} onclick="console.log(this)">
                            <label>${time.substring(0,5)}</label>
                        </div>
                    </div>`;
            }

        });

        $("#columnLeft").html(radioLeft);
        $("#columnRight").html(radioRight);

    }

    function saveAttendance(rawDtAttendance = '', idBarber = '') {

        if (rawDtAttendance == null || idBarber == null) {
            return false;
        }

        data = new FormData();
        data.append('rawDtAttendance', rawDtAttendance);
        data.append('idBarber', idBarber);

        new Promise(function(resolve, reject) {
            $.ajax({
                url: "./control/getAllAttendanceAvailableTime.php",
                type: "POST",
                data: data,
                dataType: "json",
                async: true,
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    createRadioAvaliableTime(response.RESULT);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    return reject(errorThrown);
                },
            });
        });
    }
</script>