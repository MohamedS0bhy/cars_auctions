// load all open auctions for user 
// for home blade file
function getAllOpenAuctions(){
    console.log('all open auctions');
    $.ajax({
        type : 'GET',
        url : api_url + 'auction/open/all',
        data : {},
        dataType : 'json'
    }).done(function(data){
        console.log('success');
        console.log(data);
        if(data.success){
            var innerhtml = '';
            
            for(var i=0; i<data.result.length ; i++){
                // console.log(JSON.parse(data.result[i].pics)[0]);
                innerhtml += `<div class="col-md-4 block">
                                <div class="item">
                                    <div class="img">
                                        <img src="${url}uploads/${JSON.parse(data.result[i].pics)[0]}" alt="No img" >
                                    </div>
                                    <div class="details">
                                        <ul>
                                            <li>Car Name : <span id="bold">${data.result[i].car_name}</span></li>
                                            <li>State : <span id="bold">${data.result[i].state}</span></li>
                                            <li>Start Bid Date : <span id="bold">${data.result[i].start_bid_date}</span></li>
                                            <li>End Bid Date : <span id="bold">${data.result[i].end_bid_date}</span></li>
                                            <li>Start Bid Amount : <span id="bold">${data.result[i].start_bid_amount}$</span></li>
                                            <li>final Price : <span id="bold">${data.result[i].start_bid_amount}$</span></li>
                                            <li id="customLi"><a href="${url}auction/details/${data.result[i].id}">more Info -&gt; </a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>`;
            }
            $('#homeData').html(innerhtml);
        }
        else
            $('#dangerMessage').show().text(data.result);

    }).fail(function(data){
        console.log('fail');
        $('#dangerMessage').show().text(data.statusText);
    });
}

// get auction details
// for details blade file
// take auction id
function getAuctionDetails(id){
    console.log('auction details');
    $.ajax({
        type : 'GET',
        url : api_url + 'auction/' + id,
        data : {},
        dataType : 'json'
    }).done(function(data){
        console.log('success');
        
        if(data.success){
            var result = data.result;
            var pics = JSON.parse(result.pics);

            // dates vars
            var startBidDate = new Date(result.start_bid_date);
            var endBidDate = new Date(result.end_bid_date);
            // get difference between end and start bid dates in Days
            var duraion = ((parseInt(endBidDate.getFullYear()) - parseInt(startBidDate.getFullYear()))*12*30) +(((parseInt(endBidDate.getMonth()) +1) - (parseInt(startBidDate.getMonth()) +1))*30) + (parseInt(endBidDate.getDate()) - parseInt(startBidDate.getDate()));
            var datehtml = `Open for : ${duraion} Days`;

            // for carousl html
            var lists =`<li data-target="#myCarousel" data-slide-to="0" class="active"></li>` ;
            var items = `<div class="item active"><img src="${url}uploads/${pics[0]}" alt="image0"></div>`;
            
            for(var i=1 ; i< pics.length ; i++){
                lists +=`<li data-target="#myCarousel" data-slide-to="${i}"></li>` ;
                items += `<div class="item"><img src="${url}uploads/${pics[i]}" alt="image${i}"></div>`;
            }

            var innerhtml = `<div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">${lists}</ol>
                
                <!-- Wrapper for slides -->
                <div class="carousel-inner">${items}</div>
                
                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>`;
            // end carousel html

            // show add bid button if auction is open
            var isOpen = (result.state == 'open' && (endBidDate >= (new Date()))) ? true : false;
            var bidBtn = isOpen ? `<li><button class="btn  btn-success" onClick="getUserBid(${result.id})">Add Bid </button></li>` : '';
            // show auction duration in days or closed if auction is closed
            datehtml = isOpen ?  datehtml : 'Closed for now!';
            
            innerhtml += `<div class="details row">
            <ul class="col-md-8">
                <li><h3> Car Name : <span id="bold">${result.car_name}</span></h3></li>
                <li><h3> State : <span id="bold">${result.state}</span></h3></li>
                <li><h3> Start Bid Date : <span id="bold">${result.start_bid_date}</span></h3></li>
                <li><h3> End Bid Date : <span id="bold">${result.end_bid_date}</span></h3></li>
                <li><h3> Start Bid Amount : <span id="bold">${result.start_bid_amount}$</span></h3></li>
                <li><h3> final Price : <span id="bold">${result.start_bid_amount}$</span>.</h3></li>
                ${bidBtn}
            </ul>
            <div col-md-4><h1>${datehtml}</h1></div>
            </div>`;

            $('#auctionDetails').html(innerhtml);
        }
        else
            $('#dangerMessage').show().text(data.result);

    }).fail(function(data){
        console.log('fail');
        $('#dangerMessage').show().text(data.statusText);
    });
}

// to get user bid from prompt 
// then check if it's valid or not 
// then call addBid()
// auction id 
function getUserBid(id){
    console.log('user bid');
    var bid = prompt("Please enter Bid value:");
    if(bid != null){
        bid = parseFloat(bid);
        if(isNaN(bid)){
            $("#successMessage").hide();
            $('#dangerMessage').show().text("invalid Bid value!");
        }else{
            addBid(id , bid);
        }
    }
    else{
        $("#successMessage").hide();
        $('#dangerMessage').hide();
    }
}

// when change auction state from closed to open 
// to get new Bid end date from prompt from admin 
// then check if it's valid or not 
// then call changeState()
// auction id  , new auction state
function getNewEndDate(id , state){
    console.log('new end date');
    if(state == 'closed')
        changeState(id , state , null);
    else{
        var today = new Date();
        var date = prompt("Please enter New Bid End Date in this format: YYYY-mm-dd", today.getDate()+"-"+(today.getMonth()+1)+"-"+today.getFullYear());
        if(date != null){
            date = new Date(date);
            var year = date.getFullYear();
            var month = date.getMonth()+1;
            var day = date.getDate();
            if(isNaN(year) || isNaN(month) || isNaN(day)){
                $("#successMessage").hide();
                $('#dangerMessage').show().text("invalid date value or format please use this YYYY-mm-dd format!");
                $("select#auctionState"+id).val('closed');
            }else{
                var newDate = year + '-' + month + '-' + day;
                changeState(id , state , newDate);
                
            }
        }else{
            $("#successMessage").hide();
            $('#dangerMessage').hide();
            $("select#auctionState"+id).val('closed');
        }
    }
}

// add new bid
// auction id - bid value
function addBid(id , newBid){
    console.log('add bid');
    $.ajax({
        type : 'POST',
        url : api_url + 'auction/new/bid',
        data : {
            'token' : $.cookie('token'),
            'bid' : newBid,
            'id' : id
        },
        dataType : 'json'
    }).done(function(data){
        console.log('success');
        console.log(data);
        if(data.success){
            location.reload();
        }
        else{
            $("#successMessage").hide();
            $('#dangerMessage').show().text(data.result);
        }

    }).fail(function(data){
        console.log('fail');
        $("#successMessage").hide();
        $('#dangerMessage').show().text(data.statusText);
    });
}

// to get all open - closed auctions
// and load them into table in admin.index blade file
// for admin panel
function getAllAuctions(){
    console.log('all auctions');
    $.ajax({
        type : 'GET' ,
        url : api_url + 'auction/all',
        data : {},
        dataType : 'json',
    }).done(function(data){
        console.log('success');
        console.log(data);
        if(data.success){
            var panelhtml = `<table class="table table-striped"><thead><tr><th>Car Name</th><th>Price</th><th>Bids Amount</th><th>Price + Bids</th><th>Location</th><th>Start Date</th><th>End Date</th><th>Status</th></tr></thead><tbody>`;
            for(var r of data.result){
                panelhtml+= `<tr><td><a href="${url}auction/details/${r.id}" >${r.car_name}</a></td><td>${r.price}$</td><td>${r.start_bid_amount}$</td><td>${(r.price + r.start_bid_amount)}$</td><td>${r.location}</td><td>${r.start_bid_date}</td><td>${r.end_bid_date}</td>`;
                panelhtml += '<td><select id="auctionState'+r.id+'" onChange="getNewEndDate('+r.id+', this.value)"><option value="open" '+((r.state == "open") ? 'selected' : '')+'>Open</option><option value="closed" '+((r.state == "closed") ? 'selected' : '')+'>Closed</option></select></td>';
                
            }
            panelhtml+= '</tbody></table>';
            $('#panel').html(panelhtml);
        }
        else{
            $("#successMessage").hide();
            $('#dangerMessage').show().text(data.result);
        }

    }).fail(function(data){
        console.log('fail');
        $("#successMessage").hide();
        $('#dangerMessage').show().text(data.statusText);
    });
}

// for admin panel 
// used to change auction state open - closed
// if it changed from open to close endDate = null
// otherwise endDate will be the new bid end date
function changeState(id ,state , endDate){
    console.log('change state');
    $.ajax({
        type : 'POST' ,
        url : api_url + 'auction/state/change',
        data : {
            'token' : $.cookie('token'),
            'id' : id,
            'state' : state,
            'endDate' : endDate
        },
        dataType : 'json',
    }).done(function(data){
        console.log('success');
        console.log(data);
        if(data.success){
            location.reload();
        }
        else{
            $("#successMessage").hide();
            $('#dangerMessage').show().text(data.result);
            var oldState = (state == 'open')? 'closed' : 'open';
            $("select#auctionState"+id).val(oldState);
        }

    }).fail(function(data){
        console.log('fail');
        $("#successMessage").hide();
        $('#dangerMessage').show().text(data.statusText);
        var oldState = (state == 'open')? 'closed' : 'open';
            $("select#auctionState"+id).val(oldState);
    });
}


