
function create_ratting(parent_b, rate, update_rating_func) {

	const rate_container = document.createElement('div');
	rate_container.classList.add("List_container");
	rate_container.value = "List_container";
	//rate_container.id = contenur_n;
    rate_container.style.height = '20';
    rate_container.style.width = '110';
	rate_container.style.overflowY = 'hidden';
	rate_container.style.marginRight = 'auto';
	rate_container.style.textAlign = 'center';
	//rate_container.style.display = 'grid';
	rate_container.style.boxShadow = 'var(--box-shadow)';
	rate_container.style.position ='relative';

    for (let i = 0; i < 5; i++) {
        const product_profile_Img = document.createElement('img');
        product_profile_Img.style.height = 'auto';
        product_profile_Img.style.width = '19%';
        product_profile_Img.accessKey = i;
        const r =  parseInt(rate);
        console.log('going torate_company rated', r);
        let str = 'Img/Icons/rating/star0.png'; // else put empty
        if (i == 0){
            if(r > 0) str = 'Img/Icons/rating/star1.png'; // put hafe
            if(r > 10) str = 'Img/Icons/rating/star2.png'; // put full
        }
        else if (i == 1){
            if(r > 20) str = 'Img/Icons/rating/star1.png'; // put hafe
            if(r > 30) str = 'Img/Icons/rating/star2.png'; // put full
        }
        else if (i == 2){
            if(r > 40) str = 'Img/Icons/rating/star1.png'; // put hafe
            if(r > 50) str = 'Img/Icons/rating/star2.png'; // put full
        }
        else if (i == 3){
            if(r > 60) str = 'Img/Icons/rating/star1.png'; // put hafe
            if(r > 70) str = 'Img/Icons/rating/star2.png'; // put full
        }
        else if (i == 4){
            if(r > 80) str = 'Img/Icons/rating/star1.png'; // put hafe
            if(r > 90)str = 'Img/Icons/rating/star2.png'; // put full
        }
        product_profile_Img.onclick = function (event){
            update_rating_func(parseInt(event.target.accessKey));
        };
        product_profile_Img.onerror = function() {
            this.src = str; //Set the error image path
        };
        product_profile_Img.src = str; //Set the error image path
        rate_container.appendChild(product_profile_Img);
    }
    parent_b.appendChild(rate_container);
}

//productGrid_container.addEventListener('scroll', handleScroll);
