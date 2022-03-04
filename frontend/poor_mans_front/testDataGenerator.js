


//////////////////////////////////////////// Test functions for data fetching ////////////////////////////////////////////
function testData_fetchListOfCategories()
{
    return ["Biologija", "Računarstvo"];
}

function testData_fetchCoursesByCategory(category)
{
    // https://hr.wikipedia.org/wiki/Popis_besplatnih_i_javno_dostupnih_sveu%C4%8Dili%C5%A1nih_video_predavanja
    const biologyCourses = [];

    biologyCourses[0] =
    {
        name: "Human Behavioral Biology",
        university: "Sveučilište Stanford",
        lecturer: "Robert Sapolsky",
        language: "Engleski",
        year: 2010,
        numOfLectures: 25,
        totalHours: 36,
        courseCode: "BIO 150",
        description: "This course focuses on how to approach complex normal and abnormal behaviors through biology and how to integrate disciplines including sociobiology, ethology, neuroscience, and endocrinology to examine behaviors such as aggression, sexual behavior, language use, and mental illness.",
        link1_name: "YouTube lista",
        link1_URL: "https://www.youtube.com/playlist?list=PL848F2368C90DDC3D",
        link2_name: "Web stranica",
        link2_URL: "http://www.infocobuild.com/education/audio-video-courses/biology/bio-150-human-behavioral-biology-stanford.html",
        image_URL: "https://img.youtube.com/vi/NNnIGh9g6fA/2.jpg"
    }

    biologyCourses[1] =
    {
        name: "Biology Test 2",
        university: "Sveučilište Stanford",
        lecturer: "Robert Sapolsky",
        language: "Engleski",
        year: 2010,
        numOfLectures: 25,
        totalHours: 36,
        courseCode: "CODE",
        description: "This course focuses on how to approach complex normal and abnormal behaviors through biology and how to integrate disciplines including sociobiology, ethology, neuroscience, and endocrinology to examine behaviors such as aggression, sexual behavior, language use, and mental illness.",
        link1_name: "YouTube lista",
        link1_URL: "https://www.youtube.com/playlist?list=PL848F2368C90DDC3D",
        link2_name: "Web stranica",
        link2_URL: "http://www.infocobuild.com/education/audio-video-courses/biology/bio-150-human-behavioral-biology-stanford.html",
        image_URL: "https://img.youtube.com/vi/NNnIGh9g6fA/2.jpg"
    }

    addTestDataToCourseList(biologyCourses, "Bio test", 5);

    const computerScienceCourses = [];

    computerScienceCourses[0] =
    {
        name: "Human Behavioral Biology",
        university: "Sveučilište Stanford",
        lecturer: "Robert Sapolsky",
        language: "Engleski",
        year: 2010,
        numOfLectures: 25,
        totalHours: 36,
        courseCode: "BIO 150",
        description: "This course focuses on how to approach complex normal and abnormal behaviors through biology and how to integrate disciplines including sociobiology, ethology, neuroscience, and endocrinology to examine behaviors such as aggression, sexual behavior, language use, and mental illness.",
        link1_name: "YouTube lista",
        link1_URL: "https://www.youtube.com/playlist?list=PL848F2368C90DDC3D",
        link2_name: "Web stranica",
        link2_URL: "http://www.infocobuild.com/education/audio-video-courses/biology/bio-150-human-behavioral-biology-stanford.html",
        image_URL: "https://img.youtube.com/vi/NNnIGh9g6fA/2.jpg"
    }

    addTestDataToCourseList(computerScienceCourses, "CS test", 7);

    if (category == "Biologija") return biologyCourses;
    else if (category == "Računarstvo") return computerScienceCourses;
    else return [];
}

function addTestDataToCourseList(courseList, baseName, count)
{
    for (i = courseList.length; i < count; i++)
    {
        courseList[i] =
        {
            name: baseName + i,
            university: "Test" + i,
            lecturer: "Test" + i,
            language: "Engleski",
            year: 2025,
            numOfLectures: 42,
            totalHours: 42,
            courseCode: "Test" + i,
            description: "Test" + i,
            link1_name: "YouTube lista",
            link1_URL: "https://www.youtube.com/playlist?list=PL848F2368C90DDC3D",
            link2_name: "Web stranica",
            link2_URL: "http://www.infocobuild.com/education/audio-video-courses/biology/bio-150-human-behavioral-biology-stanford.html",
            image_URL: "https://img.youtube.com/vi/NNnIGh9g6fA/2.jpg"
        }
    }
}