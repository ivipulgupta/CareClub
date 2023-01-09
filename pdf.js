window.onload = function () {
    document.getElementById("download").addEventListener("click", () => {
        const idCard = this.document.getElementById("idCard");
        console.log(idCard);
        console.log(window);
        var opt = {
            margin: 1,
            filename: 'myVounteerId.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
        };
        html2pdf().from(idCard).set(opt).save();
    });
}