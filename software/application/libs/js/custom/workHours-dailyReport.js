$(document).ready(function () {
    $("#dayForm").on("submit", function () {
        if ($("#data").val().match(/^\d{4}\-\d{1,2}\-\d{1,2}$/)) {
            $.ajax("/workHours/dailyReport", {
                method: "POST", success: function (data, textStatus, jqXHR) {
                    let tableBody = $("<tbody></tbody>");
                    try {
                        let json = JSON.parse(data);
                        let costoTotaleParagraph = $("#costoTotale");
                        if (json.length > 0) {
                            let totalCost = 0.00;
                            for (let i = 0; i < json.length; i++) {
                                let dataRow = json[i];
                                let tableRow = $("<tr></tr>");
                                tableRow.append("<th scope='row'>" + dataRow.nome_risorsa + "</th>");
                                tableRow.append("<td>" + dataRow.nome_lavoro + "</td>");
                                tableRow.append("<td>" + dataRow.numero_ore + "</td>");
                                tableRow.append("<td>" + dataRow.costo.toFixed(2) + " CHF</td>");
                                tableBody.append(tableRow);
                                totalCost += parseFloat(dataRow.costo);
                            }
                            if (costoTotaleParagraph.length > 0) {
                                costoTotaleParagraph.remove();
                            }
                            $("#main").append("<p id=\"costoTotale\">Costo totale: " + totalCost.toFixed(2) + " CHF</p>");
                        } else {
                            if (costoTotaleParagraph.length > 0) {
                                costoTotaleParagraph.remove();
                            }
                            tableBody.append("<th colspan='5'>Impossibile trovare ore di lavoro durante la giornata specificata.</th>");
                        }
                        $("tbody").remove();
                        $("table").append(tableBody);
                    } catch (SyntaxError) {
                        if (tableBody.find("th").length > 0) {
                            tableBody.remove("th");
                        }
                        tableBody.append("<th colspan='5'>" + data + "</th>");
                    }

                }, data: {"risorsa": $("#risorsa").val(), "data": $("#data").val()}
            });
        }
        return false;
    });
});