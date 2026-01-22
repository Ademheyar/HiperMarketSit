function create_contacts(parent_b, contacts_info) {
    const infos = JSON.parse(contacts_info);
	const rate_container = document.createElement('div');
	rate_container.classList.add("List_container");
	rate_container.value = "List_container";
	//rate_container.id = contenur_n;
	rate_container.style.overflowY = 'auto';
	rate_container.style.marginRight = 'auto';
	rate_container.style.textAlign = 'center';
	//rate_container.style.display = 'grid';
	rate_container.style.boxShadow = 'var(--box-shadow)';
	rate_container.style.position ='relative';
    rate_container.style.display = 'flex';
    rate_container.style.flexDirection = 'column';
    rate_container.style.gap = '0.5rem';


    for (let i = 0; i < infos.length; i++) {
        const Info_container = document.createElement('div');
        Info_container.classList.add("List_container");
        Info_container.value = "List_container";
        //Info_container.id = contenur_n;
        Info_container.style.width = '100%';
        Info_container.style.marginRight = 'auto';
        Info_container.style.display = 'flex';
        Info_container.style.textAlign = 'center';
        Info_container.style.backgroundColor = 'white';
        Info_container.style.boxShadow = 'var(--box-shadow)';
        Info_container.style.position ='relative';
        
        const product_profile_Img = document.createElement('img');
        product_profile_Img.style.height = 'auto';
        product_profile_Img.accessKey = i;
        const r =  50;
        console.log('going torate_company rated', r);
        let str = 'Img/Icons/Messages.png'; // else put empty
        Info_container.appendChild(product_profile_Img);
        if (infos[i][0] == "Phone") str = 'Img/Icons/Phone.png'; 
        if (infos[i][0] == "Phone Number") str = 'Img/Icons/Phone.png'; 
        if (infos[i][0] == "What App") str = 'Img/Icons/Phone.png'; 
        if (infos[i][0] == "Location") str = 'Img/Icons/Location.png'; 
        if (infos[i][0] == "Gmail") str = 'Img/Icons/Gmail.png'; 
        if (infos[i][0] == "Email") str = 'Img/Icons/Gmail.png'; 
        product_profile_Img.onerror = function() {
            this.src = 'Img/Icons/Messages.png'; //Set the error image path
        };
        product_profile_Img.src = str; //Set the error image path


        var email_Label = document.createElement('label');
        email_Label.textContent = infos[i][0];
        email_Label.style.fontSize = 'small';

        var email0 = document.createElement('label');
        email0.textContent = infos[i][1];
        email0.style.fontSize = 'small';
        Info_container.appendChild(email_Label);
        Info_container.appendChild(email0);

        rate_container.appendChild(Info_container);
    }
    parent_b.appendChild(rate_container);
}

//productGrid_container.addEventListener('scroll', handleScroll);
