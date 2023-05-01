function createNestedList(textList) {
  const textListFormatted = textList.replace(/\s/g, '');
  const main_nestedList = [];
  let text = '';
  let i = 0;
  function createsublist(sub_nestedList){
    text = '';  
    let new_nestedList = [];
    for (; i < textListFormatted.length; i++) {
      const character = textListFormatted[i];
      if (character === ' ') {
        text = text;
      }
      else if (character === ':') {
        new_nestedList = [text, []];
        i++;
        new_nestedList = createsublist(new_nestedList);
        sub_nestedList[1].push(new_nestedList);
        text = '';
      }
      else if (character === ',') {
        new_nestedList = [text, []];
        sub_nestedList[1].push(new_nestedList);
        text = '';
      }
      else if (character === ';') {
        new_nestedList = [text, []];
        sub_nestedList[1].push(new_nestedList);
        text = '';
        return sub_nestedList;
      }
      else {
        text += character;
      }
    }
    return sub_nestedList;
  }

  let new_nestedList = [];
  for (; i < textListFormatted.length; i++) {
    const character = textListFormatted[i];
    if (character === ' ') {
      text = text;
    }
    else if (character === ':') {
      new_nestedList = [text, []];
      i++;	
      new_nestedList = createsublist(new_nestedList);
      main_nestedList.push(new_nestedList);
      text = '';
    }
    else if (character === ',') {
      new_nestedList = [text, []];
      main_nestedList.push(new_nestedList);
      text = '';
    }
    else if (character === ';') {
      new_nestedList = [text, []];
      main_nestedList.push(new_nestedList);
      text = '';
    }
    else {
      text += character;
    }
  }
  return main_nestedList;
}

const textList = "Tops:Shirts,Tshirts:long;Sweaters,Hoodies,Tank_tops,Tunics,Henley_shirts,Polo_shirts:short;Buttondown_shirts,Flannel_shirts,Thermal_tops,Camisoles;Bottoms:Pants,Jeans,Shorts:long,short;Skirts,Leggings,Sweatpants,Joggers,Culottes,Palazzo_pants,Capris,Gauchos;Outerwear:Jackets,Coats,Raincoats,Trenches;";
//const textList = "Tops:Shirts,Tshirts:long;,Sweaters,Hoodies,Tank_tops,Tunics,Henley_shirts,Polo_shirts:short;,Buttondown_shirts,Flannel_shirts,Thermal_tops,Camisoles;Bottoms:Pants,Jeans,Shorts:long,short;,Skirts,Leggings,Sweatpants,Joggers,Culottes,Palazzo_pants,Capris,Gauchos;Outerwear:Jackets,Coats,Raincoats,Trenches;";
const first_list = createNestedList(textList);
console.log(first_list);

function sortWords(text, nestedListElement) {
  const words = text.split(' ');
  let currentLevel = nestedListElement;
  let sortedWords = [];
  for (let i = 0; i < currentLevel.length; i++) {
    const [category, subCategories] = currentLevel[i];
    if (words.includes(category)) {
      sortedWords.push(category);
      currentLevel = subCategories;
      i = -1;
      words.splice(words.indexOf(category), 1);
    }
  }
  const te = String(sortedWords.concat(words)).replace(',', ' ');
  if(te != '') return te;
  else return "";
}

function sortTextByHierarchy(text, hierarchy) {
  let words = text.split(' ');
  let sortedWords = [];
  let currentLevel = hierarchy;
  for (let i = 0; i < words.length; i++) {
    let word = words[i];
    for (let item of currentLevel) {
      if (item[0] === word && !sortedWords.includes(word)) {
        i = -1;
        sortedWords.push(item[0]);
        currentLevel = item[1];
        break;
      }
    }
  }    
  return sortedWords.join(' ');
}

function findHierarchy(searchTerm, tree) {
  console.log("in find hierarchy");
  const labels = searchTerm.split(' ');
  function searchNode(node, labelIndex) {
    const rootNode = [];
    console.log("find["+labelIndex+"] {"+labels.length+"} ("+labels[labelIndex]+")");
    for (let i = 0; i < node.length; i++) {
      console.log("node[i][0]=" + node[i][0]);
      if (node[i][0] === labels[labelIndex]) {
        console.log("node[0] = " +  labels[labelIndex]);
        const result = searchNode(node[i][1], labelIndex + 1);
        if (labelIndex === labels.length - 1) {
          return node;
        }
 
        if (result) {
          return result;
        }
      }
      else{
        rootNode.push(node[i][0]);
      }
    }
    return rootNode;
  }

  return searchNode(tree, 0);
}


function reverseNestedList(nestedList) {
  let strList = "";
  for (let i = 0; i < nestedList.length; i++) {

    if (Array.isArray(nestedList[i])) {
      strList += nestedList[i][0];
      if(nestedList[i][1].length > 0) strList += ":";
      else if (i < nestedList.length - 1) {
        strList += ",";
      }else strList += ";";
      strList += reverseNestedList(nestedList[i][1]);
    } else {
      strList += nestedList[i];
      if (i < nestedList.length - 1) {
        strList += ";";
      }
    }
  }
  return strList;
}
