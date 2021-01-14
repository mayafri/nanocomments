function timeDecode(timestamp) {
	let date = new Date(timestamp * 1000);
	
	let str = date.toISOString().slice(0, 10);
	str += ' '+date.toISOString().slice(11, 16);
	
	return str;
}

function markdownDecode(textcontent) {
	result = textcontent;
	
	// Gras **
	result = result.replace(/\*\*(.+?)\*\*/gm, `<strong>$1</strong>`);
	result = result.replace(/__(.+?)__/gm, `<strong>$1</strong>`);

	// Italique *
	result = result.replace(/\*(.+?)\*/gm, `<em>$1</em>`);
	result = result.replace(/_(.+?)_/gm, `<em>$1</em>`);

        // Code bloc ```
        result = result.replace(/```((.|\n)+?)```/gm, `<pre>$1</pre>`);

	// Code inline `
	result = result.replace(/`(.+?)`/gm, `<code>$1</code>`);

	// Liens HTTP(S)
	result = result.replace(/\s+(https?:\/\/\S+)\s+/gm, `<a href="$1" target="_blank">$1</a>`);

	// Liens balisés en Markdown [Perdu](http://perdu.com)
	result = result.replace(/\[(.+?)\]\((\S+)\)/gm, `<a href="$2" target="_blank">$1</a>`);
	
	return result;
}

function showComments(conf, json_comments) {
	let comments = JSON.parse(json_comments);
	let container_div = document.querySelector(conf.comments_div);

	container_div.innerHTML = '';
	for (var i in comments) {
		let c = comments[i];
		let html = '<div class="comment" id="comment-'+i+'">';
		html += '<p class="comment-header">';
		html += timeDecode(c['time'])+' - ';
		if(c['website']) {
			html += '<a href="'+c['website']+'" target="_blank">';
			html += c['name'];
			html += '</a>';
		}
		else {
			html += c['name'];
		}
		html += '</p>';
		html += '<p class="comment-content">';
		html += markdownDecode(c['content'])+'</p></div>';
		container_div.innerHTML += html;
	}
}

function loadComments(conf) {
	let xhr = new XMLHttpRequest();
	xhr.open('GET', conf.comments_path+'/'+conf.page_id+'.json');
	xhr.send();
	xhr.onload = function() {
		if (xhr.status == 200) {
			showComments(conf, xhr.response);
		}
	};
}

function addComment(conf) {
	let c_name = document.querySelector(conf.new_comment_div+' input[name=name]');
	let c_website = document.querySelector(conf.new_comment_div+' input[name=website]');
	let c_content = document.querySelector(conf.new_comment_div+' textarea');
	let submit_button = document.querySelector(conf.new_comment_div+' button');
	let error_field = document.querySelector(conf.new_comment_div+' .errorfield');

	var xhr = new XMLHttpRequest();
	xhr.open('POST', conf.comments_path+'/addcomment.php');
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

	xhr.onload = function () {
		if (xhr.responseText.substr(0, 5) != 'error') {
			showComments(conf, xhr.response);
			submit_button.disabled = true;
			setTimeout(function() { submit_button.disabled = false; }, 5000);
			c_content.value = '';
			error_field.innerHTML = '';
		}
		else {
			switch(xhr.responseText) {
				case 'error_comments_file_too_big':
					error_field.innerHTML = "Error: the comments savefile is too big.";
					break;
				case 'error_required_values_missing':
					error_field.innerHTML = "Error: required values are missing.";
					break;
				default:
					error_field.innerHTML = "Comments unavailable now.";
			} 
		}
	};

	xhr.send('path='+conf.comments_path+
		'&page_url='+window.location.href+
		'&name='+c_name.value+
		'&website='+c_website.value+
		'&content='+c_content.value);
}

loadComments(conf);
