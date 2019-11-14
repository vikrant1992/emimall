import static com.kms.katalon.core.checkpoint.CheckpointFactory.findCheckpoint
import static com.kms.katalon.core.testcase.TestCaseFactory.findTestCase
import static com.kms.katalon.core.testdata.TestDataFactory.findTestData
import static com.kms.katalon.core.testobject.ObjectRepository.findTestObject
import com.kms.katalon.core.checkpoint.Checkpoint as Checkpoint
import plp.Resources as Resources
import plp.POM as POM
import org.testng.Assert
import org.openqa.selenium.WebDriver as WebDriver
import org.openqa.selenium.By as By
import com.kms.katalon.core.cucumber.keyword.CucumberBuiltinKeywords as CucumberKW
import com.kms.katalon.core.mobile.keyword.MobileBuiltInKeywords as Mobile
import com.kms.katalon.core.model.FailureHandling as FailureHandling
import com.kms.katalon.core.testcase.TestCase as TestCase
import com.kms.katalon.core.testdata.TestData as TestData
import com.kms.katalon.core.testobject.TestObject as TestObject
import com.kms.katalon.core.webservice.keyword.WSBuiltInKeywords as WS
import com.kms.katalon.core.webui.driver.DriverFactory as DriverFactory
import com.kms.katalon.core.webui.keyword.WebUiBuiltInKeywords as WebUI
import internal.GlobalVariable as GlobalVariable

WebDriver driver = DriverFactory.getWebDriver()

ArrayList<Integer> misCountReviews=new ArrayList<>();

int[] reviews

int j = 0

Resources.movingToSmartphonesPage()

POM p = new POM(driver)

int size = p.reviewsCount()

if (size > 0) {
    for (int i = 1; i <= size; i++) {
        String review = WebUI.getText(findTestObject('Object Repository/PLPpage/ReviewCount'))

        String[] arr = review.split(' ')

        //reviews[j] = Integer.valueOf(arr[0]);

        WebUI.click(findTestObject('Object Repository/WriteReview/VerifyEachReviewAllSmartphoneslinks'))

        String match = WebUI.getText(findTestObject('Object Repository/WriteReview/IndividualProductReviewonPDPPage'))

        if (review.equals(match)) {
   
        } else {
		misCountReviews.add(i);
            break;
        }
		
		WebUI.back();
		
		j++;
    }
}

Assert.assertEquals(misCountReviews.size,0);

