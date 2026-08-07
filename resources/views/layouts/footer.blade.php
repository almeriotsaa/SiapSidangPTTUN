<footer class="footer mt-0">

    <div class="page-container">

        <div class="footer-bottom">

            <span>
                © {{ date('Y') }} SIAP SIDANG.
                Seluruh hak cipta dilindungi.
            </span>

        </div>

    </div>

</footer>

<style>
    .footer{
    background:#ffffff;
    border-top:1px solid #E8EDF3;
    margin-top:90px;
}

.footer-content{
    display:flex;
    justify-content:space-between;
    align-items:center;
    padding:45px 0 30px;
    gap:40px;
}

.footer-title{
    font-family:'Source Serif 4', serif;
    color:#17375E;
    font-size:30px;
    font-weight:700;
    margin-bottom:8px;
}

.footer-desc{
    color:#6B7280;
    line-height:1.8;
    margin:0;
}

.footer-links{
    display:flex;
    gap:28px;
    flex-wrap:wrap;
}

.footer-links a{
    color:#4B5563;
    text-decoration:none;
    font-weight:500;
    transition:.3s;
}

.footer-links a:hover{
    color:#E4B028;
}

.footer-bottom{
    border-top:1px solid #ECECEC;
    padding:20px 0;
    text-align:center;
    color:#6B7280;
    font-size:15px;
}

@media(max-width:768px){

    .footer-content{
        flex-direction:column;
        text-align:center;
    }

    .footer-links{
        justify-content:center;
    }

}
</style>